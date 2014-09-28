<?php
include_once("PHP/class.Skaner.php");
include_once("PHP/class.PolaczZBazaMySql.php");
include_once("PHP/class.Login.php");	
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
}

?>