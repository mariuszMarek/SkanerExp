<?php
	include_once("interface.Karta.php");
	class KartaEXP implements karta
	{
		private $troophy = array();
		private $nick;
		private $exp;
		private $lvl;
		private $mnoznik;
		private $nrKarty;
		private $liczbaPunktow;
		private $idKartyWBazie;
		private $idPoziomuKartyWBazie;
		
		private static $polaczenie;
		public function __construct($polacznie)
		{
			self::$polaczenie 		= $polacznie;
			
		}
		public function addCard($elementyKarty)
		{
			$this->nick 			= $elementyKarty['K_Nick'];
			$this->exp  			= $elementyKarty['K_EXP'];
			$this->lvl				= $elementyKarty['K_LVL'];
			$this->mnoznik 			= $elementyKarty['K_mnoznik'];
			$this->liczbaPunktow	= $elementyKarty['K_liczbaPunktow'];
			$this->nrKarty			= $elementyKarty['K_nrKarty'];
			$this->troophy			= $elementyKarty['tytuly'];
			
			if(!isset($this->idKartyWBazie))		{$this->idKartyWBazie = $this->nrKarty;}
			$this->inserty();
		}
		public function selectCard($nrKarty) // do wyswietlenia karty
		{
			// $sql = "SELECT *
			
		}
		protected function inserty() // na tym etapie wiem ze nie ma karty o danym numerze w bazie
		{
			// $wynik = true;
			if(isset($this->nrKarty ) and isset($this->nick))
			{
				$sql 		= "INSERT INTO `nrkart`(`idnrKart`, `nick`,`poziomy_idKlienta`) VALUES ('".$this->nrKarty ."', '".$this->nick ."', '".$this->nrKarty ."')";	
				// echo $sql."<br>";
				$wynik 		= mysqli_query(self::$polaczenie,$sql);
				if(!$wynik) 	{echo "nie udalo sie dodac karty nowej, przerywam skrypt<br>";  return false; exit;}
				$idKarty 	= mysqli_insert_id(self::$polaczenie);
				if(!isset($this->idKartyWBazie))
				{
					$this->idKartyWBazie = $idKarty;
				}
			}
			
			if(isset($this->troophy))
			{
				foreach($this->troophy as $klucz)
				{
					foreach($klucz as $indeks=>$nazwy)
					{
						$sql 		= " INSERT INTO `rodzajestatosow` (`typy`, `nazwyStatusow_idnazwyStatusow`) 
										VALUES ('nazwa', (SELECT `idnazwyStatusow` FROM `nazwyStatusow` WHERE `nazwyStatusow` = '".$nazwy."'))";
						$wynik 		= mysqli_query(self::$polaczenie,$sql);
						// echo $sql."<br>";
						if(!$wynik) 	{echo "nie udalo sie dodac rodzaju statosow, przerywam skrypt<br>";  return false; exit;}
						$idTypu 	= mysqli_insert_id(self::$polaczenie);
			
						$idKarty 	= $this->idKartyWBazie;
						
						$sql 		= "INSERT INTO `nrKart_has_RodzajeStatosow` (`nrKart_idnrKart`,`RodzajeStatosow_idRodzajeStatosow`) VALUES ('".$idKarty."', '".$idTypu."')";
						$wynik 		= mysqli_query(self::$polaczenie,$sql);
						if(!$wynik) 	{echo "nie udalo sie dodac osiagniec do nowej karty, przerywam skrypt<br>"; return false; exit;}
					}
				}
			}
			
			if(isset($this->exp) and isset($this->nrKarty) and isset($this->lvl) and isset($this->liczbaPunktow))
			{
				$sql = "INSERT INTO `poziomy`(`idKlienta`, `poziom`, `mnoznik`, `exp`)
						VALUES ('".$this->nrKarty ."', '".$this->lvl ."', '".$this->mnoznik ."', '".($this->exp + $this->liczbaPunktow)."')";
						$wynik 		= mysqli_query(self::$polaczenie,$sql);
						// echo $sql."<br>";
				if(!$wynik) 	{echo "nie udalo sie dodac poziomu do karty nowej, przerywam skrypt<br>"; return false;  exit;}			
			}			
		}
		protected function selecty()
		{
		
		}
		protected function updejtyKarty()
		{
		
		}
	}

	// interface karta
	// {
		// public function __construct($polaczenie);
		// public function addCard($arrayOfElements);
		// public function addPointsToCard($nrKarty,$pointsEXP);
		// public function selectCard($nrKarty);
		// }
?>