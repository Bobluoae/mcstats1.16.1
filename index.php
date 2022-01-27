<?php 
include "functions.php";
include "db/database.php";

// //testa db
// $query = mysqli_query($conn, "SELECT * FROM `worlds`");

// while($world = mysqli_fetch_assoc($query)){
// 	echo $world["id"] . " | " . $world["name"] . "<br>";
// }



///////////////////////////
//HÄMTA FRÅN SPELFILERRRRIRIRIRI&&

$saves = "C:\\Users\\erik.kallgren\\AppData\\Roaming\\.minecraft\\saves";
$myWorlds = laddaDirectory($saves);
$allstats = [];

//clear db
mysqli_query($conn, "DELETE FROM worlds");
mysqli_query($conn,  "ALTER TABLE `worlds` AUTO_INCREMENT=1");

foreach ($myWorlds as $world) {
	//if (substr($world, 0, 3) == "New") {
		//Send to db
		mysqli_query($conn, "INSERT INTO worlds SET name = '{$world}'");

		//Skapa sökväg för denna specifika värld till stats filen
		$worldDir = $saves ."/". $world ."/stats/";

		//Läs alla filnamn i stats
		$statDir = laddaDirectory($worldDir);
		
		//Anropa getstats med första filnamnet i mappen
		if (getStats($worldDir . $statDir[0]) == true) {
			$allstats[$world] = getStats($worldDir . $statDir[0]);

			//TODO Stoppa in stats i DB för denna värld
			//
			//Loopa igenom allstats för att sätta in i DB
			//
			//if-satser för att kolla om en stat redan finns
			//
			//if value finns, spara i DB 
		}
		

	//}
}

// nu finns stats in en array

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php foreach($allstats as $title => $stats) : ?>
	<table border="20">
		<tr>
			<th colspan="2">
				<?=$title?>
			</th>
		</tr>
		<?php foreach($stats as $key => $value) : ?>
		<tr>
			<td><?=$key?></td>
			<td><?=$value?></td>
		</tr>
		<?php endforeach ?>		
	</table>
	<?php endforeach ?>	

</body>
</html>