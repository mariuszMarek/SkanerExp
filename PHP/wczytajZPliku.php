<?php
ini_set('auto_detect_line_endings',true);

include_once("class.Zaleznosci.php");

$plikWej = ".\\PDki.csv";

$linie = file($plikWej);

$kontener = new Kontener();
$nowaKarta = Kontener::nowaKarta();

foreach($linie as $linia)
{
	$linia = trim($linia);
	$tabTMP = explode(";",$linia);
	
	$tabKarta['K_Nick']		 		= $tabTMP[3];
	$tabKarta['K_EXP']		 		= $tabTMP[4];
	$tabKarta['K_LVL']		 		= $tabTMP[5];
	$tabKarta['K_mnoznik'] 			= 1;
	$tabKarta['K_liczbaPunktow']	= $tabTMP[4];
	$tabKarta['K_nrKarty']			= $tabTMP[2];
	
	$nowaKarta->addCard($tabKarta);
	
	if($wynikDoadawaniaKarty === true)
	{
		$duplikat = false;
		$wynikDoadawaniaKarty = 0;
		echo "jest dobrze";
	}
	if($wynikDoadawaniaKarty === 1062)	
		{
			$duplikat = true;
			echo "duplikat";
			exit;
		}
	elseif($wynikDoadawaniaKarty != 0)
	{
	echo "nie obs³ugiwany b³¹d, proszê spróbowaæ jeszcze raz z tymi samymi ustawieniami lub daæ mi znaæ";
	exit;
	}
	// $tabKarta['tytuly'] 			= ""; // tutaj dorobic 
	
	// if(isset($elementyKarty['K_Nick']))				{$this->nick 			= $elementyKarty['K_Nick'];}
			// if(isset($elementyKarty['K_EXP']))				{$this->exp  			= $elementyKarty['K_EXP'];}
			// if(isset($elementyKarty['K_LVL']))				{$this->lvl				= $elementyKarty['K_LVL'];}
			// if(isset($elementyKarty['K_mnoznik']))			{$this->mnoznik 		= $elementyKarty['K_mnoznik'];}
			// if(isset($elementyKarty['K_liczbaPunktow']))	{$this->liczbaPunktow	= $elementyKarty['K_liczbaPunktow'];}
			// if(isset($elementyKarty['K_nrKarty']))			{$this->nrKarty			= $elementyKarty['K_nrKarty'];}
			// if(isset($elementyKarty['tytuly']))				{$this->troophy			= $elementyKarty['tytuly'];}
	// 0 - miejsce
	// 1 - link do zdjecia
	// 2 - karta
	// 3 - nick
	// 4 - exp
	// 5 - poziom
	
	// 1;"<img src=""http://exp.szczecin.pl/wp-content/uploads/2014/06/23.gif"" alt=""Onion"" class=""aligncenter size-full"" />";23;ONION;17400;VI
}

?>