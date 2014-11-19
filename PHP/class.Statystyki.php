<?php
include_once("inteface_Statystyki.php");
class wynikStatystyk extends Statystyki
{
// abstract protected function drukujWynik();
	// abstract protected function wykonajZapytanie($ktore);
	// abstract protected function przedzialCzasowy();
		private $startD; private $endD;
		
		private static $polaczenie;
		
		public function __construct($polacznie)
		{
			self::$polaczenie 		= $polacznie;		
		}
		public function wykonajZapytanie($ktore)
		{
			swtich($ktore)
			{
				case "Aktywnosc" : $this->przedzialCzasowy(); break;
			}
		}
		
		private function przedzialCzasowy()
		{
			$zapytanie = "	SELECT `kartyNumer`, `liczbaExp` 
							FROM `datadodaniaexp` 
							WHERE `timeStamp` >= '".$this->startD."' AND `timeStamp` <= '".$this->endD."' 
							ORDER BY `liczbaExp` DESC";
			$wynik = mysqli_query(self::$polaczenie,$zapytanie);
			if(mysqli_num_rows($wynik) > 0)
				{
					while($linia = mysqli_fetch_assoc($wynik))
					{
						$linia = "<tr><td>".$wynik['kartyNumer']."</td><td>".$wynik['liczbaExp']."</td></tr>";
						echo $linia;
					}
					return true;
				}
		}
		
		public function setPrzedzialy($min,$max)
		{
			$this->startD	= $min;
			$this->endD		= $max;
		}
}

?>