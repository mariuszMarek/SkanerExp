<?php session_start();

$wyswietl = 1;
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;}
if(!isset($_SESSION["zalogowany"]))		{$_SESSION["zalogowany"] = 0;}
if($_SESSION["zalogowany"] == 0)		{$wyswietl = 0;}

include_once("PHP/class.Zaleznosci.php");
$kontener = new Kontener();

if(isset($_POST['nrKarty']))
{
	$nrKarty = $_POST['nrKarty'];
	$wyswietlKarte = Kontener::nowaKarta();
	
	if($wyswietlKarte->selectCard($nrKarty))
	{	
		$nick = $wyswietlKarte->getProperty("nick");
		$lvl  = $wyswietlKarte->getProperty("lvl");
		$epx  = $wyswietlKarte->getProperty("exp");	
	}
	else
	{
		unset($_POST['nrKarty']);
	}
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<html lang="pl">
  <head>
    <title>System obsługi kart Pubu EXP</title>
	<meta http-equiv="content-type" content="text/html">
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
				<li><a href="statystyki.php"><b>»</b>Statystyki</a></li>
                <li><a href="skanerPage.php"><b>»</b>Obsługa kart</a></li>
				<?php if($wyswietl == 0)
				{?>
							<li><a href="logowanie.php"><b>»</b>Nie zalogowany</a></li>
				<?php					}else
				{?>
					<li><a href="zapiszDoPliku.php"><b>»</b>Zapis bazy do pliku</a></li>
					<li><a href="dodajNowaKarteDoBazy.php"><b>»</b>Dodaj nowego klienta</a></li>
					<li><a href="usunKarteZBazy.php"><b>»</b>Usuń klienta</a></li>
					<li><a href="rachunek.php"><b>»</b>Otwórz rachunek</a></li>
					<li><b> </b>Zalogowany</li>
					<form method = "post">
					<input type ="hidden" name = "wylogowanie" value = "1">
					<input type="submit" value = "Wyloguj" name="wylogowanie"/>
					</form>
				<?php
				}?>
             </ol>
        </div>
        <div id="content">
             <center>Główna Strona</center>
				<br>
				<br>
				<br>
			<hr>				
				<form method="post">
				<table>
				<tr><td>Numer Karty</td><td><input type="number" min="0" max="99999" step="1" name = "nrKarty"></td><td><input type="submit" value ="Szukaj">  </td></tr>
				
				</form>
				<?php 
				if(isset($_POST['nrKarty']) and ($_POST['nrKarty'] != ""))
				{
				?>
				
						<tr><td>Nick</td>			<td><?php print $nick ?></td>
						<tr><td>Lvl</td>			<td><?php print $lvl ?></td>
						<tr><td>Exp</td>	<td><?php print $epx ?></td>
						<tr><td>Nr Karty</td>	<td><?php print $nrKarty ?></td>
					</table>
				<?php
				}
				?>
			</hr>
		</div>

  </body>
</html>

