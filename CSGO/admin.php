<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-03-05
 * Filen hanterar adminsidan på hemsidan
 */
session_start();
if (((!isset($_COOKIE["loggedin"])) || ($_COOKIE["loggedin"] == "FALSE")) || ($_COOKIE["admin"] != "t"))	//Om man inte är admin redirectas man till index.php
{
	header("Location: index.php");	
}
//Inkluderar klasserna
require_once ('class/funktion.class.php');
require_once ('class/namnlist.class.php');
$fk = new FunktionClass;		//Skapar ett objekt tillö funktionsklassen


if(isset($_POST['logout']))				//Kontrollerar vilken man klickat på
{												//Anropar funktion eller redirectar beroende på.
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
elseif(isset($_POST['forum']))
{
	header("Location:forum.php");
}

if(isset($_POST['fnamnStig']))				
{											
	$sort = new namnlist('FÖRNAMN');
}
elseif(isset($_POST['epost']))
{
	$sort = new namnlist('EPOST');
}
elseif(isset($_POST['enamnStig']))
{
	$sort = new namnlist('EFTERNAMN');
}
elseif(isset($_POST['nick']))
{
	$sort = new namnlist('NICK');
}
else 
{
	$sort = new namnlist('EFTERNAMN');
}

if (isset($_POST['makeAdmin']))
{
	if ($_POST['adminEpost'] != "")
	{
		$fk->makeAdmin($_POST['adminEpost']);
	}
}
if (isset($_POST['skrivNyhet']))
{
	if ($_POST['rubrik'] != "" && $_POST['content'] != "")
	{
		$fk->makeNews($_POST['rubrik'], $_POST['content']);
	}
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="main.js"></script>
	<title>Nollans CS:GO server</title>		<!-- SÄTTER TITEL -->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="wrapper">
		<header>
		<a href="admin.php"><img src="images/adminadmin.png" alt="error"/></a><!-- SÄTTER BILD -->
			<br>
		<form action="forum.php" method="post"><!-- SKAPAR FORM -->
			<input type="submit" class="button" name="hem" value="Hem"/>
			<?php $fk->printButtons(); ?>	<!-- ANROPAR FUNKTION -->
		</form>
		</header>
		<br><br>
		<main>
			<div class="info">
				<h2>
					På denna sida kan du som administratör 
					göra medlemmar till administratör eller 
					skapa nyheter för servern!
				</h2>
			</div>
			
			<h3>
				Sortera nuvarande medlemmar efter:
			</h3>

			<form action="admin.php" method="post"><!-- SKAPAR FORM -->
					<input type="submit" class="sbutton" name="fnamnStig" value="FÖRNAMN"/>
					<input type="submit" class="sbutton" name="epost" value="E-POST"/>
					<input type="submit" class="sbutton" name="enamnStig" value="EFTERNAMN "/>
					<input type="submit" class="sbutton" name="nick" value="NICK"/>
			</form>
			<table>
				<?php $sort->printList(); ?>	<!-- ANROPAR FUNKTION -->
			</table>
			<br><br><br>
			<form action="admin.php" method="post"><!-- SKAPAR FORM -->
				<p>Skriv in den epost som tillhör den du vill göra till admin:</p>
				<input type="text" name="adminEpost" onkeyup="suggest(this.value)" size="30" /><br>
				<span id="suggest"></span><br><br>
				<input type="submit" class="button" name="makeAdmin" value="Gör till admin!"/>
			</form>
			<br><hr><br>
			<h3>
				Skapa en ny nyhet här:
			</h3>
			<form action="admin.php" method="post"><!-- SKAPAR FORM -->
				<p>Rubrik</p><input type="text" name="rubrik" size="30" />
				<p>Innehåll :</p><textarea name="content" /></textarea><br><br>
				<input type="submit" class="button" name="skrivNyhet" value="Skapa Nyhet"/>
			</form>
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