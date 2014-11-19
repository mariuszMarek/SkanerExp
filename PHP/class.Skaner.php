<?php
include_once("interfaceSkaner.php");
// include_once("class.PolaczZBazaMySql.php");
	class Skaner Implements scaner
	{
		private $nrKarty;
		private $tablicaKart = array();
		private static $polaczenie;
		function __construct($polaczenieBazy)
		{
			self::$polaczenie = $polaczenieBazy;
		}
		public function walidacjaKarty($nr)
		{
			// polaczenie do bazy i sprawdzenie czy istnieje karta w systemie;
			$zapytanieKontrolne = "SELECT `idnrKart` FROM `nrkart` WHERE `idnrKart` ='".$nr."'";
			$wynik = mysqli_query(self::$polaczenie,$zapytanieKontrolne);
			$liczbaWierszy = mysqli_num_rows($wynik);
			// echo $liczbaWierszy."##Liczba Wierszy<br>";
			return $liczbaWierszy;
		}
		public function setNrKarty($nr)
		{
			if($this->walidacjaKarty($nr) > 0)
			{
				$this->nrKarty = $nr;
				return true;
			}
			return false;
		}
		public function getNrKarty()
		{
			if(isset($this->nrKarty)) return $this->nrKarty;
			return false;
		}
		public function savePointsToCard($nrKarty,$liczbaPunktow)
		{
			if($this->walidacjaKarty($nrKarty))
			{
			
				$mnoznik = 1;
				$sql = "SELECT `mnoznik` FROM `poziomy` 
				WHERE `idKlienta` IN (SELECT `poziomy_idKlienta` FROM `nrkart` WHERE idnrKart = '".$nrKarty."')";
				$wynik = mysqli_query(self::$polaczenie, $sql);
				if(mysqli_num_rows($wynik) > 0)
				{
					while($linia = mysqli_fetch_assoc($wynik))
					{
						$mnoznik = $linia['mnoznik'];
					}	
				}
				if($mnoznik <= 0 ) {$mnoznik = 1;}
				$mnoznik = 1;
				$liczbaPunktow = $liczbaPunktow*$mnoznik;
				
				// UPDATE `poziomy`

				
				$zapytanie = "
				UPDATE `poziomy`
				SET `exp` = `exp` +'".$liczbaPunktow."' 
				WHERE `idKlienta` IN (SELECT `poziomy_idKlienta` FROM `nrkart` WHERE idnrKart = '".$nrKarty."')";
				// echo "##".$zapytanie."<br>";
				// ehco
				$wynik = mysqli_query(self::$polaczenie,$zapytanie);
				if(!$wynik)			{return 0;}
				
				$zapytanie = "
				UPDATE `poziomy`
				SET `poziom` = CASE
								WHEN `exp` >= '30000' THEN 8
								WHEN `exp` >= '20000' THEN 7
								WHEN `exp` >= '10000' THEN 6
								WHEN `exp` >= '5000' THEN 5
								WHEN `exp` >= '2000' THEN 4
								WHEN `exp` >= '1000' THEN 3
								WHEN `exp` >= '500' THEN 2
								WHEN `exp` >= '200' THEN 1
								else  9
								END	
				WHERE `idKlienta` IN (SELECT `poziomy_idKlienta` FROM `nrkart` WHERE idnrKart = '".$nrKarty."')";
				
				$wynik = mysqli_query(self::$polaczenie,$zapytanie);
				if(!$wynik)			{return 0;}
				return true;
			}
			return false;
		}
	}
?>