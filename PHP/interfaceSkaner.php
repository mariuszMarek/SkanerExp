<?php
interface scaner
{
	public function walidacjaKarty($nr);
	public function setNrKarty($nr);
	public function getNrKarty();
	public function savePointsToCard($nrKarty,$liczbaPunktow);
}

?>