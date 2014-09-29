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
		}
		public function selectCard($nrKarty)
		{
		
		}
		public function addPointsToCard($nrKarty,$pointsEXP)
		{
		
		}
		private function zapytania($rodzaj, $opcja)
		{
			if($rodzaj == "INSERT")
			{
				// $zapytanie = $rodzaj." INTO
				if($opcja == "dodatki")
				{
				foreach($this->troophy as $klucz=>$nazwy)
				{
					$sql 	= " INSERT INTO `rodzajestatosow` (`typy`, `nazwyStatusow_idnazwyStatusow`) 
								VALUES (\'nazwa\', (SELECT `idnazwyStatusow` FROM `nazwyStatusow` WHERE `nazwyStatusow` = \'".$nazwy."\'))";
					$wynik 	= mysqli_query(self::$polaczenie,$sql);
					
					$idTypu 	= mysqli_insert_id(self::$polaczenie);
					$sql 		= "INSERT INTO `nrkart`(`idnrKart`, `nick`) VALUES (\'999\', \'szatan\')";	
					$idKarty 	= 
				
				}
				
				}

			}
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