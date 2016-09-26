<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar KONTAKTSIDAN på hemsidan
 */
session_start();
//Funktion för att se så att man är inloggad!!!
require_once ('class/funktion.class.php');
$fk = new FunktionClass;

if(isset($_POST['logout']))				//Kontrollerar vilken man klickat på
{										
	$fk->logout();
}
elseif(isset($_POST['forum']))
{
	header("Location:forum.php");
}
elseif(isset($_POST['hem']))
{
	header("Location:index.php");
}
elseif(isset($_POST['registrera']))
{
	header("Location:registrera.php");
}
elseif(isset($_POST['nyhet']))
{
	header("Location:news.php");
}
elseif (isset($_POST['skickaAdmin']))
{
	$fk->contactAdmin($_POST['epost'], $_POST['detail']);
}


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
			<a href="kontakt.php"><img src="images/kontakt.png" alt="error"/></a>
			<?php $fk->adminButton(); ?><!-- ANROPAR FUNKTION -->
			<br>
		<form action="kontakt.php" method="post">
				<input type="submit" class="button" name="hem" value="Hem"/>
				<?php $fk->printButtons(); ?><!-- ANROPAR FUNKTION -->
			</form>
		</header>
	
		<main>
			<div class="mid">
				<h2>
					Nuvarande admins! 
				</h2>
				<table>
					<?php $fk->printAdmins(); ?><!-- ANROPAR FUNKTION -->
				</table>
				<p>
					<br><br>
					Kontakta admins antingen via mejl <br>
					eller direkt via formuläret här nedan!<br>
					<br> Vårt mål är att besvara dina frågor inom 24timmar. <br>
					<b>Glöm inte</b> att skriva i en korrekt epost för att få svar!
				</p>
				<br>
				<form action="kontakt.php" method="post"><!-- SKAPAR FORM -->
					<p>Skriv in din epost:</p><input type="email" name="epost" size="30" />
					<p>Din fundering :</p><textarea name="detail" ></textarea><br><br>
					<input type="submit" class="button" name="skickaAdmin" value="Skicka"/>
				</form>
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