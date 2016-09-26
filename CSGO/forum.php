<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar forumsidan på hemsidan
 */
session_start();
if ((!isset($_COOKIE["loggedin"])) || ($_COOKIE["loggedin"] == "FALSE"))	//Om man inte är inloggad redirectas man till index.php
{
	header("Location: index.php");	
}
//Funktion för att se så att man är inloggad!!!
require_once ('class/funktion.class.php');
$fk = new FunktionClass;


if(isset($_POST['logout']))				//Kontrollerar vilken man klickat på
{										//Anropar funktion eller redirectar beroende på
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
elseif(isset($_POST['nyhet']))
{

	header("Location:news.php");
}
elseif(isset($_POST['postInlägg']))
{
	$fk->postInlägg($_POST['name'], $_POST['detail']);
	header("Refresh:0");
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
		<a href="forum.php"><img src="images/forum.png" alt="error"/></a>
		<?php $fk->adminButton(); ?><!-- ANROPAR FUNKTION -->
			<br>
		<form action="forum.php" method="post">
			<input type="submit" class="button" name="hem" value="Hem"/>
			<?php $fk->printButtons(); ?><!-- ANROPAR FUNKTION -->
		</form>
		</header>
	
		<main>
			<br><br>
			<div class="info">
				<h4>
					Här kan du skriva ett inlägg om du har en allmän fundering eller bara vill tjöta!
					Du kan också läsa andras inlägg här nedan. Tänk på att hålla en god ton och ett
					trevligt språk. <u>All form av kränkning och liknande är förbjuden.</u>
				</h4>
			</div>
				
			<form action="forum.php" method="post"><!-- SKAPAR FORM -->
				<p>Namn</p><input type="text" name="name" size="30" />
				<p>Inlägg</p><textarea name="detail" /></textarea><br><br>
				<input type="submit" class="button" name="postInlägg" value="Posta inlägg"/>
			</form>
			<br>
			<table>
				<tr>
					<td>
						Namn
					</td>
					<td>
						Inlägg
					</td>
					<td>
						Loggning
					</td>
				</tr>
				<?php $fk->printInlägg(); ?><!-- ANROPAR FUNKTION -->
			</table>
			
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