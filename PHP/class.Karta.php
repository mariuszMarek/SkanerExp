<?php
	include_once("interface.Karta.php");
	class KartaEXP implements karta
	{
		private $troophy = array();
		private static $polaczenie;
		public function __construct($polacznie, $elementyKarty)
		{
			$this->zawartoscKarty = $elementyKarty;
			self::$polaczenie = $polacznie;
		}
	}

	interface karta
	{
		public function __construct($polaczenie, $arrayOfElements);
		public function addCard($nrKarty);
		public function selectCard($nrKarty);
		public function addPointsToCard($nrKarty,$pointsEXP);
	}
?>