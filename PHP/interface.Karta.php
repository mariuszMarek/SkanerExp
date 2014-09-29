<?php
	interface karta
	{
		public function __construct($polaczenie);
		public function addCard($arrayOfElements);
		public function addPointsToCard($nrKarty,$pointsEXP);
		public function selectCard($nrKarty);
	}
?>