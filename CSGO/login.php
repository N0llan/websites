<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar LOGINSIDAN på hemsidan
 */
session_start();

require_once ('class/funktion.class.php');
$fk=new FunktionClass;


if ((!isset($_COOKIE["loggedin"])) || ($_COOKIE["loggedin"] == "FALSE"))	//Om man inte är inloggad redirectas man till index.php
{
	header("Location: index.php");	
}


if(isset($_POST['logout']))				//Kontrollerar vilken man klickat på
{											
	$fk->logout();
}
elseif(isset($_POST['hem']))
{
	header("Location:index.php");
}
elseif(isset($_POST['kontakt']))
{
	header("Location:kontakt.php");
}
elseif(isset($_POST['forum']))
{
	header("Location:forum.php");
}
elseif(isset($_POST['nyhet']))
{
	header("Location:news.php");
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
			<a href="login.php"><img src="images/inlogg.png" alt="error"/></a>
			<?php $fk->adminButton(); ?><!-- ANROPAR FUNKTION -->
			<br>
		<form action="login.php" method="post">
				<input type="submit" class="button" name="hem" value="Hem"/>
				<?php $fk->printButtons(); ?><!-- ANROPAR FUNKTION -->
			</form>
		</header>
	
		<main>
			<div class="mid">
				<h1><!-- SKRIVER UT VÄLKOMMEN TILL DEN INLOGGADE ANVÄNDAREN -->
					Hej <?php echo $_SESSION["nick"]; ?> välkommen in i värmen. 
				</h1>
				<h2>
					På den här sidan kan du inte göra så mycket. Men knappa runt ska du se att du hittar information
					som du kan finna intressant. Du kanske kommer till forumet och lägger in ett inlägg där, vem vet.<br> Åter igen välkommen 
					hit!
				</h2>
				<img src="images/nollanSouth.PNG" alt="error"/>
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