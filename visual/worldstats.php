<?php 

//testa db
$query = mysqli_query($conn, "SELECT * FROM `worlds`"); 

?>

<form method="GET">
	<select name="world_id"> 

<?php

while($world = mysqli_fetch_assoc($query)){
	//

	?>

	<option value="<?php echo $world["id"]; ?>"<?= (get("world_id") == $world["id"] ? "selected":"")?>>
		<?php echo $world["id"] . " | " . $world["name"] . "<br>";?>
	</option>
	
	<?php
}

?> 

</select>
<input type="hidden" name="page" value="worlds">
<input type="hidden" name="world" value="chosen">
<input type="submit" name="" value="Skicka">
</form>

<?php  

if (get("world")=="chosen") {
	echo "<br><hr><br>";

	$query = mysqli_query($conn, "SELECT * FROM `statgroups`");

	while($statgroups = mysqli_fetch_assoc($query)){
		// echo $statgroups["id"] . " | " . $statgroups["groupname"] . "<br>";
		$link = "?world_id=" . get("world_id") . "&page=worlds&world=chosen&group=" . $statgroups["id"];
		echo $statgroups["id"] . ' | <a href="' . $link . '">' . $statgroups["groupname"] . '</a><br>';
	}


	if (is_numeric(get("group"))) {

		echo "Group " . get("group") . " is chosen <br>"; 

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
			ORDER BY
				g.groupname, s.statname;
		");

		?>
		<table border=1>
		<tr>
		<th>Stat</th>
		<th>Value</th>
		</tr>
		<?php
		while($row = mysqli_fetch_assoc($query)) {
			echo "<tr>";
			echo "<td>" . $row["statname"] . "</td>";
			echo "<td>" . $row["value"] . "</td>";
			echo "</tr>";

		}
		?>
		</table>
		<?php
	} else {
	 	echo "Group not " . get("group") . " chosen";
	}
} else {
	echo "Välj Värld";
}