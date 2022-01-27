<?php
function import($conn){

	//clear db
	mysqli_query($conn, "DELETE FROM worlds");
	mysqli_query($conn,  "ALTER TABLE `worlds` AUTO_INCREMENT=1");

	$saves = "C:\\Users\\Erik\\AppData\\Roaming\\.minecraft\\saves";
	$myWorlds = laddaDirectory($saves);
	$allstats = [];


	foreach ($myWorlds as $world) {
	//if (substr($world, 0, 3) == "New") {
		//Send to db
		mysqli_query($conn, "INSERT INTO worlds SET name = '{$world}'");

		$worldId = mysqli_insert_id($conn);

		//Skapa sökväg för denna specifika värld till stats filen
		$worldDir = $saves ."/". $world ."/stats/";

		//Läs alla filnamn i stats
		$statDir = laddaDirectory($worldDir);
		
		//Anropa getstats med första filnamnet i mappen
		if (getStats($worldDir . $statDir[0]) == true) {
			$allstats[$world] = getStats($worldDir . $statDir[0]);

			foreach($allstats[$world] as $key => $value){
				//Separera stat namnet
				$statnameparts = explode( "/", $key);

				//skapa statgroup om inte finns
				
				$test = mysqli_query($conn, "SELECT groupname FROM statgroups WHERE groupname = '{$statnameparts[1]}'");

				if (mysqli_num_rows($test) == 0) {
					mysqli_query($conn, "INSERT INTO statgroups SET groupname = '{$statnameparts[1]}'");
				}
				

				//skapa stats om inte finns
				$test2 = mysqli_query($conn, "SELECT id, statname FROM stats WHERE statname = '{$statnameparts[2]}'");



				if (mysqli_num_rows($test2) == 0) {
					mysqli_query($conn, "INSERT INTO stats SET statname = '{$statnameparts[2]}'");
					$statId = mysqli_insert_id($conn);
				} else {
					$res = mysqli_fetch_array($test2); 
					$statId = $res["id"];
				}



				//skapa value för 1 stat på 1 world
				mysqli_query($conn, "INSERT INTO world_stat SET world_id = '{$worldId}', stat_id='{$statId}', value = {$value}");
			}


			//TODO Stoppa in stats i DB för denna värld
			//
			//Loopa igenom allstats för att sätta in i DB
			//
			//if-satser för att kolla om en stat redan finns
			//
			//if value finns, spara i DB 
		}
	}
}