<?php session_start();

include_once("PHP/class.Zaleznosci.php");
$kontener = new Kontener();

$wyswietl = 1;
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;}
if(!isset($_SESSION["zalogowany"]))		{$_SESSION["zalogowany"] = 0;}
if($_SESSION["zalogowany"] == 0)		{$wyswietl = 0;}

$dataKonc = date("Y-m-d");
$dataPocz = date("Y-m")."-01";
$rodzajSortowania = "ASC";

if(isset($_SESSION['dataKonc']))		{$dataKonc = $_SESSION['dataKonc'];}
if(isset($_SESSION['dataPocz']))		{$dataPocz = $_SESSION['dataPocz'];}

if(isset($_GET['ASC']))						{$rodzajSortowania = "ASC";}
if(isset($_GET['DESC']))					{$rodzajSortowania = "DESC";}

if(isset($_GET['DataPocz']) and (!preg_match('/^$/',$_GET['DataPocz'])))				{$dataPocz 		   = $_GET['DataPocz'];}
if(isset($_GET['DataKonc']) and (!preg_match('/^$/',$_GET['DataPocz'])))				{$dataKonc 		   = $_GET['DataKonc'];}
echo $rodzajSortowania."<br>";
echo $dataKonc."<br>";
echo $dataPocz."<br>";
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
             <center>Statystyki</center>
				<br>
				<br>
				<br>
			<hr>
				<center>
				lista najbardziej aktywnych klientów
				<br>
				<br>
				<form name="PodanieDaty">
				Podaj Date startową <input type="date" name="DataPocz" style="margin : 0px 0px 10px -1px"><br>
				Podaj Date końcową  <input type="date" name="DataKonc" ><br>
				<button type="submit" name="ASC" style="margin :10px 0px 0px 0px">ROSCNĄCO</button>
				<button type="submit" name="DESC">MALEJĄCO</button>
				</form>
				<br>
				<br>
				<table>
				<tr><td><b>Numer Karty</b></td><td></td><td></td><td><b>EXP</b></td></tr>
				<?php
				
					$_SESSION['dataPocz'] = $dataPocz;
					$_SESSION['dataKonc'] = $dataKonc;
					
					$stats = Kontener::statystyki();
					$stats->setPrzedzialy($dataPocz,$dataKonc);
					$stats->wykonajZapytanie("Aktywnosc",$rodzajSortowania); // może kiedyś będzie więcej rodzajów statystyk
					$stats->drukujWynik();
				?>		
				</table>
				</center>
			</hr>
		</div>

  </body>
</html>
