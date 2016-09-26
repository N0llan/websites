<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar funktioner från alla andra filer. Detta för att slippa dubbel kod.
 */
require_once ('./dbConnection.php');

date_default_timezone_set("Europe/Stockholm");	//Sätter timezone
//SKapat et klass för att hålla alla funktioner
class FunktionClass{	
	function __construct(){
		$this->dbConn = new dbConn();
	}
	
	public function footInfo()
	{
		echo '<p class="left">
			Ranken är baserad på antalet medlemmar. Så hjälp servern att stiga i rank och registrera dig idag! 
		</p>
		<p class="right">
			Ranken är baserad på antalet medlemmar. Så hjälp servern att stiga i rank och registrera dig idag! 
		</p>';
	}
	
	public function connectDatabase($epost, $password)	//Anslut till databas och kontrollera inmatade värden
	{
		$count = 0;
		if ($this->dbConn->connectDB())		//Skapa en connection och kolla så den lyckats
		{
			$query = "SELECT password,epost,salt1,salt2 FROM csgo.medlem";
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				while ($row = pg_fetch_row($result, $count))
				{			//Loopa medans vi har rader kvar
					if (strtolower($epost) == strtolower($row[1]))
					{		//Jämför inmatad epost med den ifrån databasen 
						$salt1 = $row[2];
						$salt2 = $row[3];
						$pw = md5($salt1.$password.$salt2);	//Skapar hash utifrån saltet och inmatade lösenordet
						if($pw == $row[0])	//Kontrollerar så rätt lösen matats in
						{
							$count = 0;
							setcookie("loggedin", "TRUE");	//sätter cookien till TRUE då man nu är inloggad
							$query = "SELECT nick,epost,admin FROM csgo.medlem";
							$result = $this->dbConn->queryDB($query);	//Ny fråga
							if ($result)
							{
								while($row = pg_fetch_row($result, $count))
								{
									if (strtolower($epost) == strtolower($row[1]))
									{			//Där epost stämmer ta nick och kolla ifall man är admin
										$_SESSION["nick"] = $row[0];
										setcookie("admin", $row[2]);
										pg_free_result($result);	//rensa
									}
									$count++;
									$this->dbConn->disconnectDB();		//Stänger anslutning till databasen
									header("Refresh:0"); //Refreshar
								}
							}		
							break;
						}
						
					}
					$count++;
				}
			} else {
				$this->dbConn->disconnectDB();
				echo "Error doing query";
			}		
		}
		else 
		{
			echo "Connection failed";
		}
		
	}
			//Funktion för att registrera sig på sidan
	public function registrera($fnamn, $enamn, $nick, $epost, $pass)
	{
		$count = 0;
		$exist = false;
		if ($this->dbConn->connectDB())		//Skapa en connection och kolla så den lyckats
		{
			$query = "SELECT epost FROM csgo.medlem";
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				while ($row = pg_fetch_row($result, $count))
				{			//Loopa medans vi har rader kvar
					if (strtolower($epost) == strtolower($row[0]))
					{		//Jämför inmatad epost med den ifrån databasen och kontrollerar att den inte redan existerar
						$exist = true;	//Existerar redan eposten i databasen sätter vi denna till true
						break;					
					}
					$count++;
				}
				if (!$exist)		//Om inmatad epost inte finns
				{
					$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$salt1 = substr(str_shuffle($chars), 0, 6);	//Skapa 2 salt
					$salt2 = substr(str_shuffle($chars), 0, 6);
					$md5_password = md5($salt1.$pass.$salt2);	//HAsha saltet tillsammans med lösenordet för att spara i DB
					$query = "INSERT INTO csgo.medlem VALUES('$fnamn','$enamn','$nick','$epost','$md5_password',FALSE,'$salt1','$salt2')";
					$result = $this->dbConn->queryDB($query);//Skapa en SQL fråga och skicka till databasen
					if ($result)	//Om vi lyckats med frågan
					{
						pg_free_result($result);	//rensa
						$this->dbConn->disconnectDB();
						$this->connectDatabase($epost, $pass);	//Loggar in ifall vi lyckats med registreringen
					}
				}
				else 
				{
					echo '<script language="javascript">';
					echo 'alert("Epost finns redan registrerad!")';
					echo '</script>';	
				}
			}		
		}
		else 
		{
			echo "Connection failed";
		}
		
	}
	
	public function registreraMenu()	//Skriver ut registrera menyn
	{
		echo '<form action="registrera.php" method="post">
					<p>Förnamn:</p><input type="text" name="fornamn" size="20" />
					<p>Efternamn:</p><input type="text" name="efternamn" size="20" />
					<p>Nick:</p><input type="text" name="nick" size="20" />
					<p>Skriv in din epost:</p><input type="email" name="epost" size="20" />
					<p>Lösenord:</p><input type="password" name="password" size="20" /><br>
					<br><p class="p2">"CAPTCHA" skriv in detta i rutan nedan:</p><p class="p1"> '. $_SESSION["captcha"]. ' </p><br>
					<br><input type="text" name="CAPTCHA" size="20" />
					<br><br><br>
					<input type="submit" class="button" name="registreras" value="Registrera mig"/>
				</form>';
	}

	public function logout()		//Loggar ut användaren
	{
		setcookie("loggedin", "FALSE");
		header("Location: index.php");	//Går till index.php
	}
	
	public function footer()		//Skriver ut footer
	{
		
		if ($this->dbConn->connectDB())		//Skapa en connection och kolla så den lyckats
		{
			$query = "SELECT COUNT(epost) FROM csgo.medlem";	//kolla antalet medlemmar
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				$members = pg_fetch_result($result, 0, 0);		//Antalet medlemmar till variabeln members
			}
		}
		pg_free_result($result);
		$this->dbConn->disconnectDB();		//Rensar och stänger
		//Funktion som sätter source på bilden  beroende på antalet
		if ($members>85)
		{
			$source = 'src="images/global.png';
		}
		elseif ($members>80)
		{
			$source = 'src="images/supreme.png';
		}
		elseif ($members>75)
		{
			$source = 'src="images/lem.png';
		}
		elseif ($members>70)
		{
			$source = 'src="images/le.png';
		}
		elseif ($members>65)
		{
			$source = 'src="images/dmg.png';
		}
		elseif ($members>60)
		{
			$source = 'src="images/mge.png';
		}
		elseif ($members>55)
		{
			$source = 'src="images/mg2.png';
		}
		elseif ($members>50)
		{
			$source = 'src="images/mg1.png';
		}
		elseif ($members>45)
		{
			$source = 'src="images/goldnovamaster.png';
		}
		elseif ($members>40)
		{
			$source = 'src="images/goldnova3.png';
		}
		elseif ($members>35)
		{
			$source = 'src="images/goldnova2.png';
		}
		elseif ($members>30)
		{
			$source = 'src="images/goldnova1.png';
		}
		elseif ($members>25)
		{
			$source = 'src="images/silverelitmaster.png';
		}
		elseif ($members>20)
		{
			$source = 'src="images/silverelit.png';
		}
		elseif ($members>15)
		{
			$source = 'src="images/silver4.png';
		}
		elseif ($members>10)
		{
			$source = 'src="images/silver3.png';
		}
		elseif ($members>5)
		{
			$source = 'src="images/silver2.png';
		}
		elseif ($members>=0)
		{
			$source = 'src="images/silver1.png';
		}
		
		
		echo '<img class="left" ' .$source . ' " alt="error"><p class="left">Nuvarande <br> server <br> rank</p>
			<img class="right" ' .$source . ' " alt="error"><p class="right">Nuvarande <br> server <br> rank</p>
			<p>Copyright © | Daniel Jennebo <br> Programvaruteknik 2014 <br> 2016-03-06</p>';
	}					//Skriver ut
	
	public function printButtons()	//Skriver ut knapparna beroende på om man är inloggad eller ej.
	{
		if ((isset($_COOKIE["loggedin"])) && ($_COOKIE["loggedin"] == "TRUE"))	//Om man är inloggad 
		{
			echo '<input type="submit" class="button" name="logout" value="Logga ut mig"/>';
			echo '<input type="submit" class="button" name="forum" value="Forum"/>';
		}
		else
		{
			echo '<input type="submit" class="button" name="registrera" value="Registrera mig"/>';
		}
		echo '<input type="submit" class="button" name="nyhet" value="Senaste Nytt"/>';
		echo '<input type="submit" class="button" name="kontakt" value="Kontakta admin"/>';
		
	}
		
	public function adminButton()		//SKriver ut adminknappen för admins
	{
		if (((isset($_COOKIE["loggedin"])) && ($_COOKIE["loggedin"] == "TRUE")) && ($_COOKIE["admin"] == "t"))
		{								//kollar så man är admin
			echo '<a href="admin.php" ><img class="setting" src="images/cog.png" alt="error"/></a>';
		}
	}

	public function makeAdmin($epost)	//Funtkion för att ge någon admin rättigheter
	{
		if ($this->dbConn->connectDB())
		{
			$query = "SELECT admin FROM csgo.medlem WHERE UPPER(epost) LIKE UPPER('".$epost."');";
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				$row = pg_fetch_row($result, 0);
				if ($row[0] != "t")	//Om användaren med eposten inte redan är admin
				{
					pg_free_result($result);		//Skapa ny fråga och ändra admin boolen
					$query = "UPDATE csgo.medlem SET admin = NOT admin WHERE UPPER(epost) LIKE UPPER('".$epost."');";
					$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen	
					pg_free_result($result);
					$this->dbConn->disconnectDB();
				}
				else
				{
					echo '<script language="javascript">';	//Annars skriver vi ut att man redan är admin
					echo 'alert("Medlemmen är redan admin!")';
					echo '</script>';
					pg_free_result($result);
					$this->dbConn->disconnectDB();
					header("Refresh:0");
				}
			}
		}
	}

	public function printAdmins()	//Funktion för att skriva ut alla admins för kontakt
	{
		$count = 0;
		if ($this->dbConn->connectDB())
		{
			$query = "SELECT firstname, lastname, epost FROM csgo.medlem WHERE admin = TRUE;";
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				echo '<tr><td><b>Förnamn</b></td><td><b>Efternamn</b></td><td><b>E-post</b></td></tr>';
				while ($row = pg_fetch_row($result, $count))	//Hämtar epost och namn för de som är admins
				{
					echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td><a href="mailto:'.$row[2].'?Subject=Support%20Nollans%20CSGO%20sida"
							target="_top">'.$row[2].'</a></tr>';	//Skriver ut infon
					$count++;
				}
				pg_free_result($result);
			}
			$this->dbConn->disconnectDB();	
		}
	}
	
	public function contactAdmin($epost, $detail)		//Funtkion för att kontakta admin
	{
		$inputsInGB = fopen("fragor.log", "a");						//Öppnar fil för skrivning och
		fwrite($inputsInGB, "EPOST:".$epost. " | FRÅGA: " .$detail . "\n");
		fclose($inputsInGB);						//Skriver frågan och eposten till fil.
		echo '<script language="javascript">';
		echo 'alert("Tack för din fråga! ")';
		echo '</script>';
		header("Refresh:0");
	}
	
	public function nyhet()			//Funktion för att skriva ut nyheter
	{
		$count = 0;
		if ($this->dbConn->connectDB())
		{
			$query = "SELECT * FROM csgo.nyhet ORDER BY skriven DESC;";	//Hämta allt från nyhetstabellen
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				while ($row = pg_fetch_row($result, $count))
				{
					echo '<h2>'.$row[0].'</h2>';		//Skriver ut rubrik, nyhet och datum
					echo '<p>('.$row[2].')</p>';
					echo '<p>'.$row[1].'</p>';
					echo '<hr>';
					$count++;
				}
				pg_free_result($result);
				$this->dbConn->disconnectDB();
			}
		}
	}
	
	public function makeNews($rubrik, $detail)		//Skapa nyhet
	{
		$date= date('Y-m-d');
		if ($this->dbConn->connectDB())		//Skapa en connection och kolla så den lyckats
		{					//Sätter in rubruk, nhyhet och dagens datum i databasen
			$query = "INSERT INTO csgo.nyhet VALUES('$rubrik', '$detail', '$date')";
			$result = $this->dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
		}
	}

	public function postInlägg($name, $detail)		//Posta ett inlägg
	{
		if ($name != "" && $detail != "") //Kollar så att alla fält är ifyllda
		{
			$inputsInGB = fopen("inlagg.php", "a");						
			fwrite($inputsInGB, "<tr><td>");		//Skriver allt till fil
			fwrite($inputsInGB, $name);
			fwrite($inputsInGB, "</td><td>");
			fwrite($inputsInGB, $detail);
			fwrite($inputsInGB, '</td><td class="td1">IP: ');
			fwrite($inputsInGB, $_SERVER['REMOTE_ADDR']);
			fwrite($inputsInGB, "<br>TID: ");
			fwrite($inputsInGB, date('Y-m-d H:i'));
			fwrite($inputsInGB, "</td></tr>\n");
			fclose($inputsInGB);																		
			
		}
		else {
			echo '<script language="javascript">';							//Skriver ut en alertbox
			echo 'alert("Du måste skriva i alla rutor!")';
			echo '</script>';
		}
		
	}
	
	public function printInlägg()				//Skriver ut inlägg på sidan
	{
		if (file_exists("inlagg.php"))				//Kollar så att filen finns
		{
			$fromFile = fopen("inlagg.php", "r");	//Öppnar fil i read läge
			if ($fromFile)							//Om filen gick att öppna
			{
				$pRad ="";										//Läs rad för rad
				while (($rad = fgets($fromFile))!== false)
				{
					if ($pRad != $rad)				//Skriver inte ut exakta dubletter.
					{
						echo $rad;						//Skriv ut rad
					}
					
					$pRad = $rad;				
				}
			}
			fclose($fromFile);						//Stäng filen
			
		}
	}
}

?>