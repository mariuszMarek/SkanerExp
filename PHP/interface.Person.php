<?php
	interface osoba
	{
		private $nick; private $lvl; private $numerKarty;
		private $grupa; private $wskaznikPunktacji;
		private $trofea = array();
		
		function __construct($nrKarty);
		public function wyswietlInformacje();
		public function otworzRachunek();
	}
?>