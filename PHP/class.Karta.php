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
			$this->nrKarty			= $elementyKarty['K_nrKarty '];
			$this->troophy			= $elementyKarty['tytuly'];
			
			if(!isset($this->idKartyWBazie))		{$this->inserty("karta");}
		}
		public function selectCard($nrKarty)
		{
		
		}
		public function addPointsToCard($nrKarty,$pointsEXP)
		{
		
		}
		protected function inserty($opcja)
		{
			// $zapytanie = $rodzaj." INTO
			if($opcja == "dodatki")
			{
				foreach($this->troophy as $klucz=>$nazwy)
				{
					$sql 		= " INSERT INTO `rodzajestatosow` (`typy`, `nazwyStatusow_idnazwyStatusow`) 
									VALUES (\'nazwa\', (SELECT `idnazwyStatusow` FROM `nazwyStatusow` WHERE `nazwyStatusow` = \'".$nazwy."\'))";
					$wynik 		= mysqli_query(self::$polaczenie,$sql);
					if(!$wynik) 	{echo "nie udalo sie dodac rodzaju statosow, przerywam skrypt<br>"; exit;}
					$idTypu 	= mysqli_insert_id(self::$polaczenie);
		
					$idKarty 	= $this->idKartyWBazie;
					
					$sql 		= "INSERT INTO `nrKart_has_RodzajeStatosow` (`nrKart_idnrKart`,`RodzajeStatosow_idRodzajeStatosow`) VALUES ('".$idKarty."', '".$idTypu."')";
					$wynik 		= mysqli_query(self::$polaczenie,$sql);
					if(!$wynik) 	{echo "nie udalo sie dodac karty nowej, przerywam skrypt<br>"; exit;}
				
				}
			}
			if($opcja == "karta")
			{
				if(!isset($this->idKartyWBazie))
				{
					$sql 		= "INSERT INTO `nrkart`(`idnrKart`, `nick`) VALUES ('".$this->nrKarty ."', '".$this->nick ."')";	
					$wynik 		= mysqli_query(self::$polaczenie,$sql);
					if(!$wynik) 	{echo "nie udalo sie dodac karty nowej, przerywam skrypt<br>"; exit;}
					$idKarty 	= mysqli_insert_id(self::$polaczenie);
				}
			}			
		}
		protected function selecty($opcja)
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