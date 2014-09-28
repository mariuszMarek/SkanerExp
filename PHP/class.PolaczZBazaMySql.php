<?php
// mysqli_connect(host,username,password,dbname);
class polaczenieZBaza
{
	private static $host 		= "127.0.0.1";
	private static $login 		= "root"; 
	private static $haslo 		= "qohxn123"; 
	private static $bazaDanych  = "expkarty";
	private static $instancja;
	private $polaczenie;
	private static $liczbaUtworzen;
	public function __construct()
	{
		if(!self::$instancja)
		{
			self::$instancja = $this;
			self::$liczbaUtworzen = 0;
			return self::$instancja;
		}
		self::$liczbaUtworzen++;
		return self::$instancja;
	}
	public function polaczenieBazy()
	{
		if(self::$liczbaUtworzen < 1)
		{
		// echo self::$host."#".self::$login."#".self::$haslo."#".self::$bazaDanych."<br>";
		$this->polaczenie = mysqli_connect(self::$host,self::$login,self::$haslo,self::$bazaDanych);
		// $zapytanie = "SELECT * FROM loginy";
			if(!$this->polaczenie)
			{
				echo "\nNie udalo sie polaczyc z baza danych";
			}
			// echo $this->polaczenie;
		}
		if(mysqli_connect_errno())
		{
		echo "dupa z polaczaniem<br?";
		return false;
		}
		return $this->polaczenie;
	}
}
?>