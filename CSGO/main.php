<?php
/*Daniel Jennebo
Denna fil index.php
ska föreslå ett eller flera 
ord som börjar på det användaren 
matat in
Programvaruteknik 2014
2016-01-24
Webbprogrammering DT058G*/
require_once ('dbConnection.php');
$count = 0;
$dbConn = new dbConn();
if ($dbConn->connectDB())		//Skapa en connection och kolla så den lyckats
{
	$query = "SELECT epost FROM csgo.medlem";
	$result = $dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
	if ($result)	//Om vi lyckats med frågan
	{
		while ($row = pg_fetch_row($result, $count))
		{			//Loopa medans vi har rader kvar
			$nameArray[] = $row[0];
			$count++;
		}
	}
}



$request = $_REQUEST["inmatat"];	//Hämtar det som inmatat är = i urlen som vi "anslöt" via. (dvs det användaren skrivit)
$suggested ="";						//Skapar en variabel till de föreslagna namnen

if ($request != "")					//Om användaren tagit bort allt i rutan så gör vi ingenting
{									//Annars går vi in i satsen
	for ($i = 0; $i < count($nameArray);$i++) //Loopar storleken av arrayen
	{								//Kollar om inmatat värde finns i varje index i arrayen. Inte casesensitive.
									//Skapar en substräng av nuvarande index från start och till storleken av inmatat värde
									//kontrollerar även så att inte förslaget vi hittat är längre än inmatat värde
									//Så att t.ex. Daniell inte ger förslag Daniel.
		if (stristr($request, substr($nameArray[$i], 0, strlen($request))) && strlen($request) <= strlen($nameArray[$i]))
		{
			$suggested = $suggested . "$nameArray[$i]<br>";	
		}							//Lägger till namnet från arrayen och en radbrytning till förslagna namn
	}
}
if ($suggested == "")				//Om vi inte hittat ett förslaget namn
{
	echo "No suggestions";			//Skriver vi ut det
}
else
{
	echo $suggested;				//Annars skriver vi ut de namn vi hittat
}
$dbConn->disconnectDB();
?>
