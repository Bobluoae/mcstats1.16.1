<?php 

//Select every entry from the worlds table
$query = mysqli_query($conn, "SELECT * FROM `worlds`"); 

?>
	<!-- Title -->
	<h1>WORLDS</h1>

	<!-- Option form to choose world -->
	<form method="GET">
		<select name="world_id"> 

	<?php
	//Loop through every entry in the query containing world names and id's
	while($world = mysqli_fetch_assoc($query)) { ?>
		
		<!-- For every loop print out the id and the name, meanwhile also being able to keep the data of the selected item -->
		<option value="<?php echo $world["id"]; ?>"<?= (get("world_id") == $world["id"] ? "selected":"")?>>
			<?php echo $world["id"] . " | " . $world["name"] . "<br>";?>
		</option>
		
	<?php } ?>

	<!-- submit button and variables for option form -->
	</select>
	<input type="hidden" name="page" value="worlds">
	<input type="hidden" name="world" value="chosen">
	<input type="submit" name="" value="Skicka">
	</form>


	<?php  
	//Logic for showing statgroups
	if (get("world")=="chosen") {
		echo "<br><hr><br>";

		//Select every entry from the table statgroups
		$query = mysqli_query($conn, "SELECT * FROM `statgroups`");

		//Loop for every item in the query and insert data into a clickable link
		while($statgroups = mysqli_fetch_assoc($query)) {
			
			$link = "?world_id=" . get("world_id") . "&page=worlds&world=chosen&group=" . $statgroups["id"] . "&groupname=" . $statgroups["groupname"];
			echo $statgroups["id"] . ' | <a href="' . $link . '">' . $statgroups["groupname"] . '</a><br>';

		}

		//If user has chosen a group, select all data accociated with the specified world, the statgroup it belongs to and also the stat names and values
		if (is_numeric(get("group"))) {

			$query = mysqli_query($conn, "
				SELECT
					w.name, g.groupname, s.statname, ws.world_id, ws.stat_id, ws.value
				FROM
				 	worlds as w,
				 	statgroups as g,
				 	stats as s,
				 	world_stat as ws
				WHERE
				 	ws.stat_id = s.id
				AND
				 	s.statgroup_id = g.id
				AND
				 	w.id = ws.world_id
				AND
				 	ws.world_id = " . get("world_id") . "
				AND 
					g.id = " . get("group") . "
				ORDER BY
					g.groupname, s.statname;
			");

			//Display name of users chosen group
			if (get("groupname")) {
			
				echo "<strong style='font-size: 25px;'>Group [" . get("groupname") . "] is chosen</strong><br>"; 
			}
			?>

			<!-- Table for displaying statistics -->
			<div id="tablebox">
				<table border=10 class="color">
				<tr>
					<th>Stat</th>
					<th>Value</th>
				</tr>

				<?php
				//Loop for every entry in the data query
				while($row = mysqli_fetch_assoc($query)) {
					echo "<tr>";
					echo "<td>" . $row["statname"] . "</td>";
					echo "<td>" . $row["value"] . "</td>";
					echo "</tr>";
				}
				?>

				</table>
			</div>

			<?php
			//Display if a group is not chosen to hint to the user they have to click the groupname
		} else {
		 	echo "Group not " . get("group") . " chosen";
		}
	} else {
		echo "Choose World";
	} ?>
</div>