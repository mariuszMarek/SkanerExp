<?php session_start();

$wyswietl = 1;
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;}
if(!isset($_SESSION["zalogowany"]))		{$_SESSION["zalogowany"] = 0;}
if($_SESSION["zalogowany"] == 0)		{$wyswietl = 0;}

 ?>
 
<!DOCTYPE html>
<?php 
include_once("PHP/class.Zaleznosci.php");
?>
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
             <center>SKANER</center>
			</br>
			</br>
			</br>
			<table  width="500" height="1">
				<tr> <td><li><a href="doliczPunkty.php"><font size="2">dolicz punkty do karty</font></a></li></td><td><li><font size="2"><a href="#">odczytaj dane z karty</a></font></li></td> </tr>
			</table>
		</div>
  </body>
</html>
