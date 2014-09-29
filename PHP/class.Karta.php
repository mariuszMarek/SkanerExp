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
		public function __construct($polacznie, $elementyKarty)
		{
			$this->zawartoscKarty	= $elementyKarty;
			self::$polaczenie 		= $polacznie;
			$this->nick 			= $elementyKarty['K_Nick'];
			$this->exp  			= $elementyKarty['K_EXP'];
			$this->lvl				= $elementyKarty['K_LVL'];
			$this->mnoznik 			= $elementyKarty['K_mnoznik'];
			$this->liczbaPunktow	= $elementyKarty['K_liczbaPunktow'];
			$this->nrKarty			= $elementyKarty['K_nrKarty '];
			$this->$troophy			= $elementyKarty['tytuly'];
		}
	}

	// interface karta
	// {
		// public function __construct($polaczenie, $arrayOfElements);
		// public function addCard($nrKarty);
		// public function selectCard($nrKarty);
		// public function addPointsToCard($nrKarty,$pointsEXP);
	// }
?>