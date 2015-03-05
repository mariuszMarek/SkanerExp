<?php session_start();

include_once("PHP/class.Zaleznosci.php");
$kontener = new Kontener();

$wyswietl = 1;
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;}
if(!isset($_SESSION["zalogowany"]))		{$_SESSION["zalogowany"] = 0;}
if($_SESSION["zalogowany"] == 0)		{$wyswietl = 0;}


if(!isset($_POST['DataPocz']) or $_POST['DataPocz'] == "")
{
	if(!isset($_SESSION['DataPocz']) or $_SESSION['DataPocz'] == "" )
	{		
		$_SESSION['DataPocz'] = date("m")."/01/".date("Y");
	}	
}
else	{$_SESSION['DataPocz'] = $_POST['DataPocz'];}

if(!isset($_POST['DataKonc']) or $_POST['DataKonc'] == "")
{
	if(!isset($_SESSION['DataKonc']) or $_SESSION['DataKonc'] == "" )
	{
		$date = new DateTime('now');
		$date->modify('last day of this month');		
		
		$_SESSION['DataKonc'] = $date->format('m/d/Y');
	}	
}
else	{$_SESSION['DataKonc'] = $_POST['DataKonc'];}


// print $_SESSION['DataKonc']."K<br>".$_SESSION['DataPocz']."P<br>";
// $_SESSION['DataKonc'] = "";
// $_SESSION['DataPocz'] = "";

if(isset($_POST['Sortowanie']))			{$_SESSION['Sortowanie'] = $_POST['Sortowanie'];}
else 
{
	if(isset($_SESSION['Sortowanie']))	{$_POST['Sortowanie'] = $_SESSION['Sortowanie'];}
	else
	{
		if(isset($_POST['Sortowanie']))	{$_SESSION['Sortowanie'] = $_POST['Sortowanie'];}
		else
		{
			$_SESSION['Sortowanie'] = "ASC";
			$_POST['Sortowanie'] 	= $_SESSION['Sortowanie'];		
		}
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="styleCSS/css/1.css" type="text/css" media="screen,projection"/>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">	
	
	<script>
	$('[name="Sortowanie"]').change(function() {$(this).closest('form').submit();} );
	$(function() {$( "#DataPocz" ).datepicker();});
	$(function() {$( "#DataKonc" ).datepicker();});

	</script>
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
				<table name="tabDat">
				<form name="PodanieDaty" method="post">
				<tr><td>Podaj Date startową</td><td></td><td><input type="text" name="DataPocz" id="DataPocz" value = "<?php print $_SESSION['DataPocz'] ?>"></td></tr>
				<tr><td>Podaj Date końcową </td><td></td><td><input type="text" name="DataKonc" id="DataKonc" value = "<?php print $_SESSION['DataKonc'] ?>"></td></tr>
				
				<tr><td>Podaj Sposób Sortowania</td><td></td><td>
				<select name="Sortowanie"">
					<option value="ASC"<?php if(isset($_SESSION['Sortowanie'])){if($_SESSION['Sortowanie'] == "ASC"){ ?> selected <?php }}?> >Rosnąco</option>
					<option value="DESC" <?php if(isset($_SESSION['Sortowanie'])){if($_SESSION['Sortowanie'] == "DESC"){ ?> selected <?php }}?> >Malejąco</option>
				</select>
				<button>Aktualizuj</button></td></tr>
				</table>
				</form>
				<br>
				<br>
				<table>
				<tr><td><b>Numer Karty</b></td><td></td><td></td><td><b>EXP</b></td></tr>
				<?php
					$stats = Kontener::statystyki();
					// $stats->setPrzedzialy("2014-10-01",date("Y-m-d"));
					// if($_GET['Sortowanie'])					
					$tabDataPocz = explode("/",$_SESSION['DataPocz']);
				
					$tabDataKonc = explode("/",$_SESSION['DataKonc']);
					
					$tmpDataPocz = $tabDataPocz[2]."-".$tabDataPocz[0]."-".$tabDataPocz[1];
					$tmpDataKonc = $tabDataKonc[2]."-".$tabDataKonc[0]."-".$tabDataKonc[1];
					
					// print $tmpDataPocz."P<br>";
					// print $tmpDataKonc."K<br>";
					
					$stats->setPrzedzialy($tmpDataPocz,$tmpDataKonc);
					if(isset($_SESSION['Sortowanie']))
					{
						$stats->wykonajZapytanie("Aktywnosc",$_SESSION['Sortowanie']);					
						$stats->drukujWynik();
					}
				?>		
				</table>
				</center>
			</hr>
		</div>

  </body>
</html>
