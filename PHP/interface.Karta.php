<?php
	interface karta
	{
		public function __construct($polaczenie);
		public function addCard($arrayOfElements);
		public function selectCard($nrKarty);
	}
?>