<?php 

// //testa db
// $query = mysqli_query($conn, "SELECT * FROM `worlds`");

// while($world = mysqli_fetch_assoc($query)){
// 	echo $world["id"] . " | " . $world["name"] . "<br>";
// }



///////////////////////////
//HÄMTA FRÅN SPELFILERRRRIRIRIRI&&



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