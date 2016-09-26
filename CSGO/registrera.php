<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar REGISTRERASIDAN på hemsidan
 */
session_start();
//Funktion för att se så att man är inloggad!!!
if ((isset($_COOKIE["loggedin"])) && ($_COOKIE["loggedin"] == "TRUE"))	//Om man är inloggad redirectas man till LOGIN.php
{
	header("Location: login.php");	
}
require_once ('class/funktion.class.php');
$fk = new FunktionClass;

if(isset($_POST['registreras']))				
{											
	if (isset($_POST['CAPTCHA']) && $_POST['CAPTCHA'] == $_SESSION["captcha"])
	{
		if ($_POST['fornamn'] != "")		//Kollar så man fyllt i alla fält
		{
			if ($_POST['efternamn'] !="")
			{
				if ($_POST['nick'] != "")
				{
					if ($_POST['password'] != "")
					{
						$fk->registrera($_POST['fornamn'],$_POST['efternamn'],$_POST['nick'],$_POST['epost'],$_POST['password']);
						header("Refresh:0");	//Anropa funktion för registrering
					}
					else
					{			//Annars skriv ut alertbox
						echo '<script language="javascript">';
						echo 'alert("Lösenord behövs!")';
						echo '</script>';
					}
				}
				else
				{
					echo '<script language="javascript">';
					echo 'alert("Nick behövs!")';
					echo '</script>';
				}
			}
			else
			{
			echo '<script language="javascript">';
			echo 'alert("Efternamn behövs!")';
			echo '</script>';
			}
		}
		else
		{
		echo '<script language="javascript">';
		echo 'alert("Förnamn behövs!")';
		echo '</script>';
		}
	}
	else
	{
		echo '<script language="javascript">';
		echo 'alert("CAPTCHA felinmatat")';
		echo '</script>';
	}
}

if(isset($_POST['kontakt']))
{
	header("Location:kontakt.php");
}
elseif(isset($_POST['forum']))
{
	header("Location:forum.php");
}
elseif(isset($_POST['hem']))
{
	header("Location:index.php");
}
elseif(isset($_POST['nyhet']))
{
	header("Location:news.php");
}

$_SESSION["chars"] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$_SESSION["captcha"] = substr(str_shuffle($_SESSION["chars"]), 0, 5);	//Skapa captcha
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nollans CS:GO server</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="wrapper">
		<header>
			<a href="registrera.php"><img src="images/Registrera.png" alt="error"/></a>
			<br>
		<form action="registrera.php" method="post">
				<input type="submit" class="button" name="hem" value="Hem"/>
				<?php $fk->printButtons(); ?><!-- ANROPAR FUNKTION -->
			</form>
		</header>
	
		<main><br>
			<p>
				Här kan du joina Nollans CS:GO server!<br> <br>
				Om du blir medlem kommer du få tillgång till forumet och om du sköter dig<br>
				kan du en dag bli administratör för sidan. Vid frågor kan du klicka på kontakta admin <br>
				länken här ovan. Annars är det bara köra igång och fylla i dessa fält nedan för att bli medlem.<br>
				<br>
				<b>DU</b> är bara några knappklick ifrån att bli medlem i en vacker gemenskap!
			</p>
			<div class="mid">
				<?php $fk->registreraMenu(); ?><!-- ANROPAR FUNKTION -->
			</div>
			
		</main>
	</div>
	<div class="down">
		<?php $fk->footInfo(); ?><!-- ANROPAR FUNKTION -->
	</div>
	<footer>
		<?php $fk->footer(); ?><!-- ANROPAR FUNKTION -->
	</footer>
	
</body>
</html>