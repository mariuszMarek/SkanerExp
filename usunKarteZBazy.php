<?php session_start();
include_once("PHP/class.Zaleznosci.php");

$kontener = new Kontener();
$nrStrony		 = 0;

if(isset($_GET['nrKarty']))
{
	$nrKarty 		= $_GET['nrKarty'];
	
	if(!$wynik) {header('refresh: 0; url=http://localhost/skanerEXP/dodajNowaKarteDoBazy.php');}
	else
	{
		unset($_SESSION['nrKarty']);
		unset($_SESSION['liczbaPunktow']);
		unset($liczbaPunktow);
		unset($nrKarty);
	}
}

if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;}
$wyswietl = 1;
if(!isset($_SESSION["zalogowany"]))	{$_SESSION["zalogowany"] = 0;}
if($_SESSION["zalogowany"] == 0)	{$wyswietl = 0;}
 ?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <title>System obsługi kart Pubu EXP</title>
    <meta charset="UTF-8">
    <meta name="Description" 	content="skaner karty">
    <meta name="Keywords" 		content="karta, skaner, pub, autorski">
    <meta name="Generator" 		content="JTHTML 8.4.1">
    <meta name="Robots" 		content="index">
    <link rel="stylesheet" href="styleCSS/css/1.css" type="text/css" media="screen,projection" />
  </head>
  <?php 
  if($brakKartyWBazie == true)	{echo '<body onload="alertFunction(\'Podany numer jest juz w bazie danych\')">';}
  else							{echo '<body OnLoad="document.obslugaKarty.nrKarty.focus(); document.obslugaKarty.liczbaPunktow.focus();">' ;}
  
  if($nrStrony == 0)
	{ ?>
			<div id="sidebar">
			   <h1><a href="index.php">Menu</a></h1>
				 <p> Wybierz poniżej co chcesz zrobić</p>
				 <ol id="nay">
					<li><a href="#"><b>»</b>Statystyki</a></li>
					<li><a href="skanerPage.php"><b>»</b>Obsługa kart</a></li>
					<?php 
					if($wyswietl == 0)
					{
						?>
						<li><a href="logowanie.php"><b>»</b>Nie zalogowany</a></li>
						<?php					
					}
					else
					{
						?>
						<li><a href="dodajNowaKarteDoBazy.php"><b>»</b>Dodaj nowego klienta</a></li>
						<li><b> </b>Zalogowany</li>
						<form method = "post">
						<input type ="hidden" name = "wylogowanie" value = "1">
						<input type="submit" value = "Wyloguj" name="wylogowanie"/>
						</form>
						<?php
					}
						?>
				 </ol>
			</div>
			<div id="content">
				 <center>Doliczanie Punktów</center>
				</br>
				</br>
				</br>
				<table  width="500" height="1">
					<tr> <td><LI><a href="#"><font size="2">dolicz punkty do karty</font></a></LI></td><td><LI><font size="2"><a href="#">odczytaj dane z karty</a></font></LI></td> </tr>
				</table>
			</div>
			<div id="content2">
			<?php 
			if($wyswietl > 0)
			{ 
				?>
				<center>Podaj numer karty<form name ="obslugaKarty">
				<input type="number" min="0" max="99999" step="1" name = "nrKarty">
				<?php
			} 
			if($wyswietl == 0){echo "<ul> Za chwilę zostaniesz poproszony o zalogowanie się do systemu</ul>";
			header('refresh: 1; url=http://localhost/skanerEXP/logowanie.php');}
			
			?>
			</div>
	<?php 
	}	
	</body>
	
</html>
