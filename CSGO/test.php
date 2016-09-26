<?php

require_once ('dbConnection.php');
$dbConn = new dbConn();
if ($dbConn->connectDB())
{
	echo 'Successful connection<br>';
	$count = 0;
	$query = "SELECT password,epost,salt1,salt2 FROM csgo.medlem";
			$result = $dbConn->queryDB($query);	//Skapa en SQL fråga och skicka till databasen
			if ($result)	//Om vi lyckats med frågan
			{
				while ($row = pg_fetch_row($result, $count)){
					echo $row[1]."<br>";
					$count++;
				}
			} else {
				echo 'query failed';
			}
} else {
	echo 'Something went wrong in connection';
}
?>