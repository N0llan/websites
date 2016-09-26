<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar NEWSSIDAN på hemsidan
 */
session_start();
require_once ('class/funktion.class.php');
$fk = new FunktionClass;

if(isset($_POST['logout']))				//Kontrollerar vilken man klickat på
{											
	$fk->logout();
}
elseif(isset($_POST['kontakt']))
{
	header("Location:kontakt.php");
}
elseif(isset($_POST['hem']))
{
	header("Location:index.php");
}
elseif(isset($_POST['registrera']))
{
	header("Location:registrera.php");
}
elseif(isset($_POST['forum']))
{
	header("Location:forum.php");
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
			<a href="news.php"><img src="images/news.png" alt="error"/></a>
			<?php $fk->adminButton(); ?><!-- ANROPAR FUNKTION -->
			<br>
		<form action="news.php" method="post">
				<input type="submit" class="button" name="hem" value="Hem"/>
				<?php $fk->printButtons(); ?><!-- ANROPAR FUNKTION -->
			</form>
		</header>
	
		<main>
			<div class="mid">
				<hr>
				<?php $fk->nyhet(); ?><!-- ANROPAR FUNKTION -->
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