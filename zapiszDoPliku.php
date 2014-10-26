<?php
include_once("PHP/class.Zaleznosci.php");
$katalog = "./Wyniki/";
// if(mkdir($katalog))

$kontener 	= new Kontener();
$dataTeraz 	= date("Y-m-d_His");
$filename	= $katalog."listaKart_".$dataTeraz.".csv";
// $filename   = str_replace("-"
$uchwyt 	= fopen($filename, "w");

// $sql 		= "	SELECT nk.nick, p.exp, p.poziom, nk.idnrKart
				// FROM nrkart nk 
				// INNER JOIN poziomy p ON p.idKlienta = nk.poziomy_idKlienta 
				// INNER JOIN nrkart_has_rodzajestatosow nk_H_rs ON nk_H_rs.nrKart_idnrKart = nk.idnrKart 
				// INNER JOIN rodzajestatosow rs ON rs.idRodzajeStatosow = nk_H_rs.RodzajeStatosow_idRodzajeStatosow 
				// INNER JOIN nazwystatusow ns ON ns.idnazwyStatusow = rs.nazwyStatusow_idnazwyStatusow
				// GROUP BY nk.nick, p.exp, p.poziom, nk.idnrKart
				// ORDER BY p.exp DESC ";
				
$sql 		= "	SELECT nk.nick, p.exp, p.poziom, nk.idnrKart
				FROM nrkart nk 
				INNER JOIN poziomy p ON p.idKlienta = nk.poziomy_idKlienta 
				GROUP BY nk.nick, p.exp, p.poziom, nk.idnrKart
				ORDER BY p.exp DESC ";				

$wynik	= mysqli_query($kontener->getPolaczenie(),$sql);

if(mysqli_num_rows($wynik) > 0 )
{

	//2 link do grafiki
	//3 karta
	//4 nick
	//5 exp
	//6 lvl
	// linkDoGrafiki - dynamicznie tworzony jak i pobieranie info z bazy czy jest + domyslnie może jakiś obrazek ?
	$ranking 					   = 0;
	$poprzedniePunktyDoswiadczenia = 1;
	$aktualnePunktyEXP		       = 1;
	
	while($linie = mysqli_fetch_assoc($wynik))
	{
	
		$exp 			   = $linie['exp'];
		$aktualnePunktyEXP = $exp;
		$nick 			   = $linie['nick'];
		$poziom			   = $linie['poziom'];
		$nrKarty		   = $linie['idnrKart'];
		
		if($aktualnePunktyEXP != $poprzedniePunktyDoswiadczenia)	{$ranking++;}
		// else
		// {
		// $ranking++;
		// }
		
		$tabWynikowa[] 	   = $ranking.";linkDoGrafiki;".$nrKarty.";".$nick.";".$exp.";".$poziom.PHP_EOL;
		$poprzedniePunktyDoswiadczenia = $exp;
	}
}
fwrite($uchwyt,"ranking;linkDoGrafiki;nrKarty;nick;exp;poziom".PHP_EOL);					
foreach($tabWynikowa as $element =>$linia)	{fwrite($uchwyt,$linia);}
fclose($uchwyt);

header("Content-type: text/plain");
header("Content-Description: File Transfer");
header("Content-disposition: attachment;filename=$filename");
header("Content-Transfer-Encoding: binary");
readfile($filename);
?>