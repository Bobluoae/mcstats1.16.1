<?php
function import($conn){

	//clear db
	mysqli_query($conn, "DELETE FROM worlds");
	mysqli_query($conn,  "ALTER TABLE `worlds` AUTO_INCREMENT=1");

	mysqli_query($conn, "DELETE FROM stats");
	mysqli_query($conn,  "ALTER TABLE `stats` AUTO_INCREMENT=1");

	mysqli_query($conn, "DELETE FROM statgroups");
	mysqli_query($conn,  "ALTER TABLE `statgroups` AUTO_INCREMENT=1");

	mysqli_query($conn, "DELETE FROM world_stat");
	mysqli_query($conn,  "ALTER TABLE `world_stat` AUTO_INCREMENT=1");

	$saves = "C:\\Users\\erik.kallgren\\AppData\\Roaming\\.minecraft\\saves";
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

				//titta om statgroup redan finns
				$query = mysqli_query($conn, "SELECT id, groupname FROM statgroups WHERE groupname = '{$statnameparts[1]}'");

				if (mysqli_num_rows($query) === 0) {
					//den fanns inte 
					mysqli_query($conn, "INSERT INTO statgroups SET groupname = '{$statnameparts[1]}'");
					$statgroup_id = mysqli_insert_id($conn);
				} else {
					//den fanns
					$res = mysqli_fetch_array($query); 
					$statgroup_id = $res["id"];
				}
				
				//titta om denna stats redan finns
				$query2 = mysqli_query($conn, "SELECT id, statname FROM stats WHERE statname = '{$statnameparts[2]}' AND statgroup_id = {$statgroup_id}");

				if (mysqli_num_rows($query2) === 0) {
					//den fanns inte 
					$sql = "INSERT INTO stats SET statname = '{$statnameparts[2]}', statgroup_id = {$statgroup_id}";
					mysqli_query($conn, $sql);
					$statId = mysqli_insert_id($conn);
				} else {
					//den fanns
					$res = mysqli_fetch_array($query2); 
					$statId = $res["id"];
				}

				//skapa value för 1 stat på 1 world
				mysqli_query($conn, "INSERT INTO world_stat SET world_id = '{$worldId}', stat_id='{$statId}', value = {$value}");
			}
		}
	}
}