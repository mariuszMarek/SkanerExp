<?php
include_once("interfaceLogin.php");
	class Logon Implements 	authorization
{
	private $log;
	private $password; 
	private static $lvlOfClearance = 0;
	private $dbConnection;
	final public function __construct($polaczenie)
	{
		$this->dbConnection = $polaczenie;
	}
	final public function authorizationProces($login,$password)
	{
		if($this->dbConnection != NULL)
		{
	
			$this->log = $login; 
			$this->password = $password;
			$zapytanie  = "SELECT lvlOfAcces FROM loginy WHERE login = '".$this->log ."' AND password = '".$this->password ."'";
			// SELECT lvlOfAcces FROM loginy WHERE login = 'test' AND password = 'test'
			echo $zapytanie."<br>";
			$result 	= mysqli_query($this->dbConnection,$zapytanie); 
			// $liczbaWierszy = mysqli_num_fields($result);

			while($wiersz = mysqli_fetch_array($result))
			{
				self::$lvlOfClearance = $wiersz["lvlOfAcces"];
				return true;
			}
			return false;
		}
	}
	public function getLVLcleareance()
	{
		return self::$lvlOfClearance;
	}
}
?>