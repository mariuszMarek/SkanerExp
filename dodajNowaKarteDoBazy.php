<?php session_start();
include_once("PHP/class.Zaleznosci.php");
$wyswietl = 1;
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;$wyswietl = 0;}
if(!isset($_SESSION["zalogowany"]))		{$_SESSION["zalogowany"] = 0;$wyswietl = 0;}

if(isset($_SESSION['nrKarty']))			{$nrKarty 		= $_SESSION['nrKarty']; 		$nrKartyPodany = 1;		  unset($_SESSION['nrKarty']);}
if(isset($_SESSION['liczbaPunktow']))	{$liczbaPunktow = $_SESSION['liczbaPunktow'];	$liczbaPunktowPodana = 1; unset($_SESSION['liczbaPunktow']);}
unset($tabKarty);

if(isset($_POST))
{
	foreach($_POST as $keys=>$value)
	{
		if(preg_match('/^K_/',$keys))		{$tabKarty[$keys] = $value;}
		if(preg_match('/^tytuly/',$keys))	{$tabKarty['tytuly'][$keys] = $value;}
	}
	unset($_POST);
}
$duplikat = false;
if(isset($tabKarty))
{
	$kontener = new Kontener();
	$nowaKarta = Kontener::nowaKarta();
	$wynikDoadawaniaKarty = $nowaKarta->addCard($tabKarty);
	if($wynikDoadawaniaKarty === true)
	{
	$duplikat = false;
	$wynikDoadawaniaKarty = 0;
	}
	if($wynikDoadawaniaKarty === 1062)	{$duplikat = true;
	}
	elseif($wynikDoadawaniaKarty != 0)
	{
	echo "nie obsługiwany błąd, proszę spróbować jeszcze raz z tymi samymi ustawieniami lub dać mi znać";
	}

	unset($tabKarty);
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
	<script type="text/javascript">
	function expand(textbox,holderPlaceString) 
	{
		var dlugosc = holderPlaceString.length;
		// document.getElementById("test").innerHTML = dlugosc;
		if (!textbox.startW) { textbox.startW = textbox.offsetWidth; }
		var style = textbox.style;
		//Force complete recalculation of width
		//in case characters are deleted and not added:
		style.width = 0;
		var desiredW = textbox.scrollWidth;
		//Optional padding to reduce "jerkyness" when typing:
		desiredW += textbox.offsetHeight;
		style.width = Math.max(desiredW, textbox.startW) + 'px';
	}
	
	function alertFunction(trescBledu) {alert(trescBledu);}
	
	</script>
	<style>
.lista {
    float: right;
	margin: -30px 200px 0px 0px;
	display:inline;
}
</style>
  </head>
  <?php    
  if($duplikat == true)
  { ?>
	<body onload="alertFunction('Podany numer jest juz w bazie danych')">
  <?php }
  else
	{ ?>
	<body>
  <?php 
	}
  ?>
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
             <center id="test">Dodanie nowej karty do systemu</center>
			 <?php if(isset($nrKartyPodany) and $nrKartyPodany == 1)
					{ ?>
					<p id="kartyNumer">Dodajesz karte o numerze <?php echo $nrKarty; ?> 
					<?php if(isset($liczbaPunktowPodana) and $liczbaPunktowPodana == 1)
							{ ?>
							i o ilości punktów <?php echo $liczbaPunktow; ?>
					<?php	} ?>
					</p>

			<?php	} ?>
				<br>
				<br>
				<br>
			<hr>
				<form method="post" name="NowaKarta">
				<ul>
					<p>		Nowa karta </p>						
					<table !important border-spacing="3px 100px">
					<tr>
						<td><li>Nick</li></td><td><input type="text" name="K_Nick" placeHolder="Nick" onkeyup="expand(this,'Nick');" required></td>
					</tr>
					<tr>
						<td><li>EXP</li></td><td><input type="number" step="1"	name="K_EXP" placeHolder="EXP" onkeyup="expand(this,'EXP');" required></td>
					</tr>
					<tr>
						<td><li>Startowy LVL</li></td><td><input type="number" step="1" name="K_LVL" placeHolder="Startowy Poziom" min="1" required></td>
					</tr>
					<tr>
						<td><li>Mnożnik</li></td><td><input type="number" step="1" name="K_mnoznik" placeHolder="Mnoznik np 1" min="1" max="1" value="1"></td>
					</tr>
					<tr>
						<td><li>Numer karty</li></td><td><input type="number" step="1" name="K_nrKarty" placeHolder="Numer Karty" min="1" <?php if(isset($nrKarty)){echo "value=\"".$nrKarty."\"";} ?> required> </td>
					</tr>
					<tr>
						<td><li>Liczba EXP'a</li></td><td><input type="number" step="1" name="K_liczbaPunktow" placeHolder="Liczba punktów na start" min="1" 
						<?php if(isset($liczbaPunktow)){echo "value=\"".$liczbaPunktow."\"";} ?> required> </td>
					</tr>
					<tr>
						<td><input type="submit" name="dodaj" value="Dodaj kartę"></td><td> <input type="reset" value="Wyczyść formularz"></td>
					</tr>
					</table>
				</ul>
			</hr>
		</div>

  </body>
</html>
