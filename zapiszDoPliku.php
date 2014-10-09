<?php
include_once("PHP/class.Zaleznosci.php");

$kontener 	= new Kontener();
$dataTeraz 	= date("Y-m-d_His");
$filename	= "listaKart_".$dataTeraz.".csv";
$uchwyt 	= fopen($filename, "w");

$sql 		= "	SELECT nk.nick, p.exp, p.poziom  
				FROM nrkart nk 
				INNER JOIN poziomy p ON p.idKlienta = nk.poziomy_idKlienta 
				INNER JOIN nrkart_has_rodzajestatosow nk_H_rs ON nk_H_rs.nrKart_idnrKart = nk.idnrKart 
				INNER JOIN rodzajestatosow rs ON rs.idRodzajeStatosow = nk_H_rs.RodzajeStatosow_idRodzajeStatosow 
				INNER JOIN nazwystatusow ns ON ns.idnazwyStatusow = rs.nazwyStatusow_idnazwyStatusow
				GROUP BY nk.nick, p.exp, p.poziom
				ORDER BY p.exp DESC ";

$wynik	= mysqli_query($kontener->getPolaczenie(),$sql);

if(mysqli_num_rows($wynik) > 0 )
{
	while($linie = mysqli_fetch_assoc($wynik))
	{
		$exp 	= $linie['exp'];
		$nick 	= $linie['nick'];
		$poziom = $linie['poziom'];
		
		$tabWynikowa[] = $nick.";".$poziom.";".$exp.PHP_EOL;
	}
}
fwrite($uchwyt,"nick;poziom;doswiadczenie".PHP_EOL);					
foreach($tabWynikowa as $element =>$linia)	{fwrite($uchwyt,$linia);}
fclose($uchwyt);

header("Content-type: text/plain");
header("Content-Description: File Transfer");
header("Content-disposition: attachment;filename=$filename");
header("Content-Transfer-Encoding: binary");
readfile($filename);
?>