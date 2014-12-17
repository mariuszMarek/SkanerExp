<?php
include_once("interface.Statystyki.php");
class wynikStatystyk extends Statystyki
{
// abstract protected function drukujWynik();
	// abstract protected function wykonajZapytanie($ktore);
	// abstract protected function przedzialCzasowy();
		private $startD; private $endD; private $wynikZapytania = array();
		
		private static $polaczenie;
		
		public function __construct($polacznie)
		{
			self::$polaczenie 		= $polacznie;		
		}
		public function wykonajZapytanie($ktore, $jak)
		{
			switch($ktore)
			{
				case "Aktywnosc" : {$this->przedzialCzasowy($jak); break;}
			}
		}
		
		private function przedzialCzasowy($jak)
		{
			$zapytanie = "	SELECT `kartyNumer`, `liczbaExp` 
							FROM `datadodaniaexp` 
							WHERE `timeStamp` >= '".$this->startD."' AND `timeStamp` <= '".$this->endD." 23:59:59' 
							ORDER BY `liczbaExp` ".$jak;
			$wynik = mysqli_query(self::$polaczenie,$zapytanie);
			if(mysqli_num_rows($wynik) > 0)
			{
				while($linia = mysqli_fetch_assoc($wynik))
				{
					$liniaTMP 	= "<tr><td>".$linia['kartyNumer']."</td><td></td><td></td><td>".$linia['liczbaExp']."</td></tr>";
					$karta 		= $linia['kartyNumer'];
					$exp 		= $linia['liczbaExp'];
					if(isset($this->wynikZapytania[$exp]))		{$this->wynikZapytania[$exp] .= $liniaTMP;}
					else										{$this->wynikZapytania[$exp] = $liniaTMP;}
				}
				return true;
			}
		}
		public function drukujWynik()
		{
			foreach($this->wynikZapytania as $punkty => $Linie)
			{
				echo $Linie;
			}
		}
		public function setPrzedzialy($min,$max)
		{
			$this->startD	= $min;
			$this->endD		= $max;
		}
}

?>