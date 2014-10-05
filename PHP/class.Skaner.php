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
				// echo $liczbaWierszy."##<br>";
				if($liczbaWierszy)
				{
					return (-1);
				}
				return 1;
			}
			public function setNrKarty($nr)
			{
				if($this->walidacjaKarty($nr))
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
				
					// jeszcze select by pobrac mnoznik punktow
					$zapytanie = "
					UPDATE `poziomy`
					SET `exp` = `exp` +'".$liczbaPunktow."'
					WHERE `idKlienta` IN (SELECT `poziomu_idKlienta` FROM `nrkart` WHERE idnrKart = \'".$nrKarty."\')";
					$wynik = mysqli_query(self::$polaczenie,$zapytanie);
					if(!$wynik)
					{
						// echo "nie udalo sie zrobic updatu dla numeru karty ".$nrKarty." z iloscia punktow ".$liczbaPunktow."<br>";
						return false;
					}
					return true;
				}
				return false;
			}
	}
?>