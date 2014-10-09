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
					$liczbaPunktow = $liczbaPunktow*$mnoznik;
					
					$zapytanie = "
					UPDATE `poziomy`
					SET `exp` = `exp` +'".$liczbaPunktow."' 
					WHERE `idKlienta` IN (SELECT `poziomy_idKlienta` FROM `nrkart` WHERE idnrKart = '".$nrKarty."')";
					// echo "##".$zapytanie."<br>";
					// ehco
					$wynik = mysqli_query(self::$polaczenie,$zapytanie);
					if(!$wynik)			{return 0;}
					return true;
				}
				return false;
			}
	}
?>