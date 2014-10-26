<?php
class expData
{
	private $exp;
	private static $connection;
	function __construct($connectionToDB)
	{
		self::$connection = $connectionToDB;
	}
	public function addExpDateToCard($cardNumber,$exp)
	{
		$sql = "INSERT INTO `datadodaniaexp` (`kartyNumer`,`liczbaExp`)
				VALUES ('".$cardNumber."', '".$exp."')";
		$wynik 		= mysqli_query(self::$connection,$sql);
		if(!$wynik) {echo "<br>Nie udalo sie dodac EXP i daty do bazy"; 
		echo mysqli_error(self::$connection)."#".mysqli_errno(self::$connection); 
		return false;}
		return true;
	}
}
?>