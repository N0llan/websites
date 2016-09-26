<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar adminsidan på hemsidan
 */
session_start();
require_once ('class/funktion.class.php');
$fk = new FunktionClass;

if(isset($_POST['login']))				//Kontrollerar vilken man klickat på
{
	header("Location:login.php");				
	$fk->connectDatabase($_POST['epost'],$_POST['password']);
	header("Location:login.php");
}
if(isset($_POST['kontakt']))
{
	header("Location:kontakt.php");
}
elseif(isset($_POST['logout']))				
{											
	$fk->logout();
}
elseif(isset($_POST['registrera']))
{
	header("Location:registrera.php");
}
elseif(isset($_POST['nyhet']))
{
	header("Location:news.php");
}
elseif(isset($_POST['forum']))
{
	header("Location:forum.php");
}
if ((isset($_COOKIE["loggedin"])) && ($_COOKIE["loggedin"] == "TRUE"))	//Om man är inloggad 
{
	header("Location:login.php");
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
		<?php $fk->adminButton(); ?><!-- ANROPAR FUNKTION -->
		<a href="index.php"><img src="images/logo.png" alt="error"/></a>
		<br>
		<form action="index.php" method="post">
			<input type="submit" class="button" name="hem" value="Hem"/>
			<?php $fk->printButtons(); ?><!-- ANROPAR FUNKTION -->
		</form>
		</header>
		
		<main>
			<p><br><br><!-- SKRIVER UT INFO -->
				<b>Hej!</b> Vad trevligt att du hittat hit!<br>
				När du väl är här finns det några bra saker att veta. 
				<br><br>
				Är du ännu inte medlem kan du lätt klicka på knappen här ovan (Registrera mig),<br>
				fylla i dina uppgifter och snabbare än ett "flickshot" är du medlem <br>
				och kan ta del av allt gött som händer på servern!
				<br><br><br>
				Du kan logga in här nedan ifall du vill komma åt medlemsspecifik <br>
				information eller vill administrera något.	
			</p>
			<div class="mid">
				<form action="index.php" method="post"><!-- SKAPAR FORM -->
					<p>Skriv in din epost:</p><input type="email" name="epost" size="20" />
					<p>Lösenord:</p><input type="password" name="password" size="20" /><br><br><br>
					<input type="submit" class="button" name="login" value="Logga in mig"/>
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