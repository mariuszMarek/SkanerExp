<?php
abstract class Statystyki
{
	abstract protected function drukujWynik();
	abstract protected function wykonajZapytanie($ktore,$jak);
}

?>