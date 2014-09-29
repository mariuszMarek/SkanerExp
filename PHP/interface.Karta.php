<?php
	interface karta
	{
		public function __construct($polaczenie, $arrayOfElements);
		public function addCard($nrKarty);
		public function selectCard($nrKarty);
		public function addPointsToCard($nrKarty,$pointsEXP);
	}
?>