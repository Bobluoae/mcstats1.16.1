<?php

//The users Windows minecraft saves directory
if (isset($_POST["path"])) {
	$saves = $_POST["path"];
	$_SESSION["path"] = $saves;
}


//For importing data to database dependent on what is in the json files
function import($conn){

	//Global error handling
	global $error;
	global $message;
	//Is specified path a directory?
	if (is_dir($_SESSION["path"])) {

		//Try catch block to make sure it doesnt throw errors at the user
		try {

			// clear db before inputing new data
			mysqli_query($conn, "DELETE FROM worlds");
			mysqli_query($conn,  "ALTER TABLE `worlds` AUTO_INCREMENT=1");

			mysqli_query($conn, "DELETE FROM stats");
			mysqli_query($conn,  "ALTER TABLE `stats` AUTO_INCREMENT=1");

			mysqli_query($conn, "DELETE FROM statgroups");
			mysqli_query($conn,  "ALTER TABLE `statgroups` AUTO_INCREMENT=1");

			mysqli_query($conn, "DELETE FROM world_stat");
			mysqli_query($conn,  "ALTER TABLE `world_stat` AUTO_INCREMENT=1");


			//Load the desired directory from called function
			$myWorlds = laddaDirectory($_SESSION["path"]);

			//Define array for all statistics
			$allstats = [];

			//Loop for every world in the saves directory
			foreach ($myWorlds as $world) {
			//if (substr($world, 0, 3) == "New") { For when you want ONLY new worlds to be scanned

				//Create directory for stats folder for a specific world
				$worldDir = $_SESSION["path"] ."/". $world ."/stats/";

				//Check if directory exists
				if (!is_dir($worldDir)) {
					throw new \Exception("This directory does not contain the correct information!");
				}

				//Send worldname to database table named 'worlds'
				mysqli_query($conn, "INSERT INTO worlds SET name = '{$world}'");
				$worldId = mysqli_insert_id($conn);

				//Read all files in stats folder - Should only be one file
				$statDir = laddaDirectory($worldDir);

				//Call getStats function with the directory of the first file
				if (getStats($worldDir . $statDir[0]) == true) {

					//Insert worldname and stats from getStats function into allstats array
					$allstats[$world] = getStats($worldDir . $statDir[0]);

					//Loop for every statistic in the specified world
					foreach($allstats[$world] as $key => $value){

						//Separate the stat name where there is a slash
						$statnameparts = explode( "/", $key);

						//Check if groupname already exists
						$query = mysqli_query($conn, "SELECT id, groupname FROM statgroups WHERE groupname = '{$statnameparts[1]}'");

						//If the groupname did not exist for this statistic, insert it into the database
						if (mysqli_num_rows($query) === 0) {

							mysqli_query($conn, "INSERT INTO statgroups SET groupname = '{$statnameparts[1]}'");
							$statgroup_id = mysqli_insert_id($conn);

						} else {

							//If the groupname already existed for this statistic, get the id of the statgroup
							$res = mysqli_fetch_array($query);
							$statgroup_id = $res["id"];
						}

						//Check if this statname already exists
						$query2 = mysqli_query($conn, "SELECT id, statname FROM stats WHERE statname = '{$statnameparts[2]}' AND statgroup_id = {$statgroup_id}");

						if (mysqli_num_rows($query2) === 0) {
							//If it does not exist enter it into the database
							$sql = "INSERT INTO stats SET statname = '{$statnameparts[2]}', statgroup_id = {$statgroup_id}";
							mysqli_query($conn, $sql);
							$statId = mysqli_insert_id($conn);
						} else {
							//If not get the id of the statname
							$res = mysqli_fetch_array($query2);
							$statId = $res["id"];
						}

						//Insert stat values into database with relational pointers to the world ID and statname ID
						mysqli_query($conn, "INSERT INTO world_stat SET world_id = '{$worldId}', stat_id='{$statId}', value = {$value}");
					}
				}
			}
		//error handling
		} catch (\Exception $e) {
			$error = true;
			$message = "The path provided does not work! Did you misspell it?";
		}
		header("Location: ?page=worlds");
		exit();
	//error handling
	} else {
		$error = true;
		$message = "You need to give your path!";
	}
}
