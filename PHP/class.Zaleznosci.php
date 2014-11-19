<?php
include_once("PHP/class.Skaner.php");
include_once("PHP/class.PolaczZBazaMySql.php");
include_once("PHP/class.Login.php");
include_once("PHP/class.Karta.php");
include_once("PHP/class.PunktyKartaData.php");
include_once("PHP/class.Statystyki.php");

	
class Kontener
{
	private static $polaczenieBaza;
	private static $instancja;
	public function __construct()
	{
	
		if(!self::$instancja)	
		{ 
			self::$instancja = $this;
			$tmpPolaczenie = new polaczenieZBaza();	
			self::$polaczenieBaza = $tmpPolaczenie->polaczenieBazy();
			return self::$instancja;
		}
		return self::$instancja;
	}
	public static function makeStat()
	{
		$stat = new wynikStatystyk(self::$polaczenieBaza);
		return $stat;
	}
	public static function makeLogin()
	{
		$login = new Logon(self::$polaczenieBaza);
		return $login;
	}
	public static function cardCheck()
	{
		$karta = new Skaner(self::$polaczenieBaza);
		return $karta;
	}
	public static function nowaKarta()
	{
		$nowaKarta = new KartaEXP(self::$polaczenieBaza);
		return $nowaKarta;
	}
	public function getPolaczenie()
	{
		return self::$polaczenieBaza;
	}
	public static function expZData()
	{
		$expData = new expData(self::$polaczenieBaza);
		return $expData;
	}
}

?>