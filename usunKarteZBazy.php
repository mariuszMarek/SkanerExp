<?php session_start();
include_once("PHP/class.Zaleznosci.php");

$nrStrony		 = 0;
$udaloSieUsunac	 = 0;

if(isset($_POST['nrKarty']) and $_POST['nrKarty'] != "")
{

	$nrKarty 		= $_POST['nrKarty'];
	$kontener		= new Kontener();
	$karta = Kontener::nowaKarta();
	if($karta->usunKarteZBazy($nrKarty))	{$udaloSieUsunac = 1;}
	else									{$udaloSieUsunac = 2;}
	// tutaj dopisać usuwanie karty, problem taki że jeszcze trzeba obsłużyć rodzaje błędów, np. brak karty w systemie.
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
	<script type="text/javascript">
	
	function myFunction() 	
	{
		var odpowiedz = confirm("Na pewno chcesz usunąć kartę z bazy danych ?\nUWAGA PROCES JES NIE ODWRACALNY !");
		
		if(odpowiedz === false)	{document.getElementById("wejNrKarty").value = 'TEST';}
	}
	function wyswietlKomunikat(kodNapisu)
	{
		var kod = kodNapisu;
		switch(kod) {
			case 'udaloSie':	{alert('Poprawnie usunelo karte z bazy danych');} break;
			case 'BrakKarty':	{alert('Nie udalo sie poprawnie usunac karte z bazy\nmoże nie być karty o danym numerze');} break;
			// case 'udaloSie':	{alert('Poprawnie usunelo karte z bazy danych');}
			}
	}
	
	</script>
  </head>
  <?php 
  
  if($udaloSieUsunac == 0)	{echo "<body>";}
  if($udaloSieUsunac == 1)  {echo "<body onload=\"wyswietlKomunikat('udaloSie')\">";}
  if($udaloSieUsunac == 2)	{echo "<body onload=\"wyswietlKomunikat('BrakKarty')\">";}
  
  if($nrStrony == 0)
	{ ?>
			<div id="sidebar">
			   <h1><a href="index.php">Menu</a></h1>
				 <p> Wybierz poniżej co chcesz zrobić</p>
				 <ol id="nay">
					<li><a href="statystyki.php"><b>»</b>Statystyki</a></li>
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
						<li><a href="zapiszDoPliku.php"><b>»</b>Zapis bazy do pliku</a></li>
						<li><a href="dodajNowaKarteDoBazy.php"><b>»</b>Dodaj nowego klienta</a></li>
						<li><a href="usunKarteZBazy.php"><b>»</b>Usuń klienta</a></li>
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
					<tr> <td><LI><a href="doliczPunkty.php"><font size="2">dolicz punkty do karty</font></a></LI></td><td><LI><font size="2"><a href="#">odczytaj dane z karty</a></font></LI></td> </tr>
				</table>
			</div>
			<div id="content2">
			<?php 
			if($wyswietl > 0)
			{ 
				?>
				<center>Podaj numer karty 
				<form id ="formTest" name ="obslugaKarty" method="post" onsubmit = "myFunction()">
					<input id="wejNrKarty" type="number" min="0" max="99999" step="1" name = "nrKarty" autofocus>
				</form>
				</center>
				<?php
			} 
			if($wyswietl == 0){echo "<ul> Za chwilę zostaniesz poproszony o zalogowanie się do systemu</ul>";
			header('refresh: 1; url=http://localhost/skanerEXP/logowanie.php');}
			
			?>
			</div>
	<?php 
	}	
	?>
	</body>
	
</html>
