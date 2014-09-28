<?php session_start();

include_once("PHP/class.Zaleznosci.php");

$kontener = new Kontener();
$obslugaLoginu = Kontener::makeLogin();
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;}
if(isset($_POST['login']) and isset($_POST['szyfrowany']))
{
$pass = $_POST['szyfrowany'];
$log  = $_POST['login'];

$wynikLogowania = $obslugaLoginu->authorizationProces($log,$pass);
if($wynikLogowania)
	{
	// echo "#".$obslugaLoginu->getLVLcleareance()."#";
	$_SESSION['zalogowany'] = $obslugaLoginu->getLVLcleareance();
	header('refresh: 0;url=http:///localhost/skanerEXP/skanerPage.php');
	}
}
$wyswietl = 1;
if(!isset($_SESSION["zalogowany"]))	{$_SESSION["zalogowany"] = 0;}
if($_SESSION["zalogowany"] == 0)	{$wyswietl = 0;}
// if($wyswietl > 0)
// {
	// header('url=http://http://localhost/skanerEXP/skanerPage.php');
// }
 ?>
 
<!DOCTYPE html>
<html lang="pl">
  <head>
    <title>System obsługi kart Pubu EXP</title>
    <meta charset="UTF-8">
    <meta name="Description" content="skaner karty">
    <meta name="Keywords" content="karta, skaner, pub, autorski">
    <meta name="Generator" content="JTHTML 8.4.1">
    <meta name="Robots" content="index">
    <link rel="stylesheet" href="styleCSS/css/1.css" type="text/css" media="screen,projection" />
  </head>
  <body>
        <div id="sidebar">
             <h1><a href="index.php">Menu</a></h1>
             <p> Wybierz poniżej co chcesz zrobić</p>
             <ol id="nay">
				<li><a href="#"><b>»</b>Statystyki</a></li>
                <li><a href="skanerPage.php"><b>»</b>Obsługa kart</a></li>
                <li><a href="skanerPage.php"><b>»</b>Nie zalogowany</a></li>
             </ol>
        </div>
        <div id="content">
             <center>Logowanie do systemu</center>
		</div>
		<div id="content2">
		<?php 
		// if($wyswietl == 1){echo "<ul> LOL TEST</ul>";} 
		if($wyswietl == 0){
		
		// <form action=\"http://localhost/skanerEXP/index.php\" onsubmit=\"if (this.szyfrowany.value == '' && this.login.value == '' ) { alert('Prosze podac haslo i login przed potwierdzeniem!'); return false; }\" method=\"post\">
		echo "<center><form action=\"http://localhost/skanerEXP/logowanie.php\" onsubmit=\"if (this.szyfrowany.value == '' && this.login.value == '' ) { alert('Prosze podac haslo i login przed potwierdzeniem!'); return false; }\" method=\"post\">
		Login <input type=\"text\" name=\"login\"/>
		Hasło <input type=\"password\" name=\"szyfrowany\" /> <input type=\"submit\" value=\"OK\" />
		</form></center>
		";}

		
		?>
		</div>
  </body>
</html>
