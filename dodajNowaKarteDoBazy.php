<?php session_start();

$wyswietl = 1;
if(isset($_POST['wylogowanie']) == "1")	{$_SESSION["zalogowany"] = 0;$wyswietl = 0;}
if(!isset($_SESSION["zalogowany"]))		{$_SESSION["zalogowany"] = 0;$wyswietl = 0;}

if(isset($_SESSION['nrKarty']))			{$nrKarty 		= $_SESSION['nrKarty']; 		$nrKartyPodany = 1;		  unset($_SESSION['nrKarty']);}
if(isset($_SESSION['liczbaPunktow']))	{$liczbaPunktow = $_SESSION['liczbaPunktow'];	$liczbaPunktowPodana = 1; unset($_SESSION['liczbaPunktow']);}

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
	
	</script>
	
  </head>
  <body>
        <div id="sidebar">
              <h1><a href="index.php">Menu</a></h1>
             <p> Wybierz poniżej co chcesz zrobić</p>
             <ol id="nay">
				<li><a href="#"><b>»</b>Statystyki</a></li>
                <li><a href="skanerPage.php"><b>»</b>Obsługa kart</a></li>
				<?php if($wyswietl == 0)
				{?>
							<li><a href="logowanie.php"><b>»</b>Nie zalogowany</a></li>
				<?php					}else
				{?>
					<li><a href="dodajNowaKarteDoBazy.php"><b>»</b>Dodaj nowego klienta</a></li>
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
             <center id="test">Główna Strona</center>
			 <?php if(isset($nrKartyPodany) and $nrKartyPodany == 1)
					{ ?>
					<p id="kartyNumer">Dodaj kartę o numerze <?php echo $nrKarty; ?> </p>
			<?php	} ?>
				<br>
				<br>
				<br>
			<hr>
				<form method="post" name="NowaKarta">
				<ul>
					<li><input type="text" name="Nick" placeHolder="Nick"  			  onkeyup="expand(this,'Nick');" >				</li>
					<li><input type="text" name="EXP"  placeHolder="EXP" onkeyup="expand(this,'EXP');" >							</li>
					<li><input type="number" step ="1" name="LVL"  placeHolder="Startowy Poziom"  min="1">							</li>
					<li><input type="number" step="0.001" name="mnoznik"  placeHolder="Mnoznik np 1,001" min="0.001" >						</li>
					
					
				</ul>
			</hr>
		</div>

  </body>
</html>
