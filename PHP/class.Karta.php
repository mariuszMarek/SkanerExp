<?php
	include_once("interface.Karta.php");
	class KartaEXP implements karta
	{
		private $troophy = array();
		private $nick;
		private $exp;
		private $lvl;
		private $mnoznik;
		private $nrKarty;
		private $liczbaPunktow;
		private $idKartyWBazie;
		private $idPoziomuKartyWBazie;
		
		private static $polaczenie;
		public function __construct($polacznie)
		{
			self::$polaczenie 		= $polacznie;
			
		}
		public function addCard($elementyKarty)
		{
			if(isset($elementyKarty['K_Nick']))				{$this->nick 			= $elementyKarty['K_Nick'];}
			if(isset($elementyKarty['K_EXP']))				{$this->exp  			= $elementyKarty['K_EXP'];}
			if(isset($elementyKarty['K_LVL']))				{$this->lvl				= $elementyKarty['K_LVL'];}
			if(isset($elementyKarty['K_mnoznik']))			{$this->mnoznik 		= $elementyKarty['K_mnoznik'];}
			if(isset($elementyKarty['K_liczbaPunktow']))	{$this->liczbaPunktow	= $elementyKarty['K_liczbaPunktow'];}
			if(isset($elementyKarty['K_nrKarty']))			{$this->nrKarty			= $elementyKarty['K_nrKarty'];}
			if(isset($elementyKarty['tytuly']))				{$this->troophy			= $elementyKarty['tytuly'];}
			if(!isset($this->idKartyWBazie))				{$this->idKartyWBazie	= $this->nrKarty;}
			return $this->inserty();
		}
		
		public function selectCard($nrKarty) // do wyswietlenia zawartosci karty, w tym poziom, nick, exp i inne glupoty
		{
			if(!isset($this->idKartyWBazie)) {$this->idKartyWBazie = $nrKarty;}
			if($this->selectCardFromDataBase() == false)	 {return false;}
		}
		
		protected function inserty() // na tym etapie wiem ze nie ma karty o danym numerze w bazie
		{
			// $wynik = true;
			mysqli_query(self::$polaczenie,"BEGIN");
			
			if(isset($this->nrKarty ) and isset($this->nick))
			{
				$sql 		= "INSERT INTO `nrkart`(`idnrKart`, `nick`) VALUES ('".$this->nrKarty ."', '".$this->nick ."')";	
				// echo $sql."<br>";
				$wynik 		= mysqli_query(self::$polaczenie,$sql);
				if(!$wynik) 	
				{
					if(mysqli_errno(self::$polaczenie) == 1062)
					{
						return mysqli_errno(self::$polaczenie);
					}
					else
					{
						echo "nie udalo sie dodac karty nowej, przerywam skrypt<br>";
						echo "<br>".mysqli_error(self::$polaczenie)."#".mysqli_errno(self::$polaczenie);
						mysqli_query(self::$polaczenie,"ROLLBACK");
						return false; 
						exit;
					}
				}
				$idKarty 	= mysqli_insert_id(self::$polaczenie);
				if(!isset($this->idKartyWBazie))
				{
					$this->idKartyWBazie = $idKarty;
				}
			}
			
			if(isset($this->troophy))
			{
				foreach($this->troophy as $klucz)
				{
					foreach($klucz as $indeks=>$nazwy)
					{
						// echo $sql."<br>";
						$sql 		= " INSERT INTO `rodzajestatosow` (`typy`, `nazwyStatusow_idnazwyStatusow`) 
										VALUES ('nazwa', (SELECT `idnazwyStatusow` FROM `nazwyStatusow` WHERE `nazwyStatusow` = '".$nazwy."'))";
						$wynik 		= mysqli_query(self::$polaczenie,$sql);
						if(!$wynik) 	{echo "nie udalo sie dodac rodzaju statosow, przerywam skrypt<br>";echo "<br>".mysqli_error(self::$polaczenie)."#".mysqli_errno(self::$polaczenie); mysqli_query(self::$polaczenie,"ROLLBACK");  return false; exit;}
						$idTypu 	= mysqli_insert_id(self::$polaczenie);
			
						$idKarty 	= $this->idKartyWBazie;
						
						$sql 		= "INSERT INTO `nrKart_has_RodzajeStatosow` (`nrKart_idnrKart`,`RodzajeStatosow_idRodzajeStatosow`) VALUES ('".$idKarty."', '".$idTypu."')";
						$wynik 		= mysqli_query(self::$polaczenie,$sql);
						if(!$wynik) 	{echo "nie udalo sie dodac osiagniec do nowej karty, przerywam skrypt<br>";echo "<br>".mysqli_error(self::$polaczenie)."#".mysqli_errno(self::$polaczenie); mysqli_query(self::$polaczenie,"ROLLBACK"); return false; exit;}
					}
				}
			}
			if(isset($this->exp) and isset($this->nrKarty) and isset($this->lvl) and isset($this->liczbaPunktow))
			{
				// echo $sql."<br>";
				$sql = "INSERT INTO `poziomy`(`idKlienta`, `poziom`, `mnoznik`, `exp`) 
						VALUES ('".$this->nrKarty ."', '".$this->lvl ."', '".$this->mnoznik ."', '". ($this->exp + ($this->liczbaPunktow * $this->mnoznik)) ."')";
				$wynik 		= mysqli_query(self::$polaczenie,$sql);
				if(!$wynik) 	{echo "nie udalo sie dodac poziomu do karty nowej, przerywam skrypt<br>";echo "<br>".mysqli_error(self::$polaczenie)."#".mysqli_errno(self::$polaczenie); mysqli_query(self::$polaczenie,"ROLLBACK"); return false;  exit;}			
			}
			
			if(isset($this->nrKarty ) and isset($this->nick))
			{
				// echo $sql."<br>";
				$sql 		= "UPDATE  `nrkart` SET `poziomy_idKlienta` = '".$this->nrKarty ."' WHERE `idnrKart` = '".$this->nrKarty."'";	
				$wynik 		= mysqli_query(self::$polaczenie,$sql);
				if(!$wynik) 	{echo "nie udalo sie dodac karty nowej, przerywam skrypt<br>";echo "<br>".mysqli_error(self::$polaczenie)."#".mysqli_errno(self::$polaczenie);mysqli_query(self::$polaczenie,"ROLLBACK");  return false; exit;}
				$idKarty 	= mysqli_insert_id(self::$polaczenie);
				if(!isset($this->idKartyWBazie))
				{
					$this->idKartyWBazie = $idKarty;
				}
			}
			
			
			mysqli_query(self::$polaczenie,"COMMIT");
			return true;
		}
		protected function selectCardFromDataBase() 
		{	
			$sql = "SELECT `idnrKart` FROM `nrkart` WHERE `idnrKart` = '".$this->idKartyWBazie ."'";
			// echo $sql;
			$wynik = mysqli_query(self::$polaczenie, $sql);
			if($wynik) 
			{
				$liczbaWierszy = mysqli_num_rows($wynik);
				if($liczbaWierszy == 0) return false;
				return true;
			}
			echo "LOL";
			return false;
		}
		protected function updejtyKarty() // tutaj cos za pewne bedzie
		{
		
		}
		public function usunKarteZBazy($nrKarty = NULL)
		{
			if($nrKarty == NULL and (!isset($this->idKartyWBazie))) {return FALSE;}
			if($nrKarty != NULL )									{$this->idKartyWBazie = $nrKarty;}
			
			if(!self::selectCardFromDataBase())	{return false;}
			
			$sql 	= "DELETE FROM `rodzajestatosow` WHERE `idRodzajeStatosow` IN (SELECT `RodzajeStatosow_idRodzajeStatosow` FROM `nrkart_has_rodzajestatosow` 
																				WHERE `nrKart_idnrKart` = '".$this->idKartyWBazie ."')";
			$wynik	= mysqli_query(self::$polaczenie, $sql);
			if(!$wynik)	{echo "nie udalo sie usunac rekordow z rodzajestatosow dla karty nr ".$this->idKartyWBazie ."<br> zamykam skrypt<br>"; return false;}
			
			$sql 	= "DELETE FROM `nrkart_has_rodzajestatosow` WHERE nrKart_idnrKart = '".$this->idKartyWBazie ."'";
			$wynik	= mysqli_query(self::$polaczenie, $sql);
			if(!$wynik)	{echo "nie udalo sie usunac rekordow z nrkart_has_rodzajestatosow dla karty nr ".$this->idKartyWBazie ."<br> zamykam skrypt<br>"; return false;}
			
			$sql 	= "DELETE FROM `nrkart` WHERE `idnrKart` = '".$this->idKartyWBazie ."'";
			$wynik	= mysqli_query(self::$polaczenie, $sql);
			if(!$wynik)	{echo "nie udalo sie usunac rekordow z nrkart dla karty nr ".$this->idKartyWBazie ."<br> zamykam skrypt<br>"; return false;}
			
			$sql 	= "DELETE FROM `poziomy` WHERE `idKlienta` = '".$this->idKartyWBazie ."'";
			$wynik	= mysqli_query(self::$polaczenie, $sql);
			if(!$wynik)	{echo "nie udalo sie usunac rekordow z nrkart dla karty nr ".$this->idKartyWBazie ."<br> zamykam skrypt<br>"; return false;}
			
			return true;
		}
	}
?>