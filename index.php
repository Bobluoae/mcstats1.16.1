<?php 
include "db/database.php";
include "logic/functions.php";
include "logic/import.php";

//ISSET
if (!isset($_GET["page"])) {
    $_GET["page"] = "";
}
if (!isset($_POST["action"])) {
	$_POST["action"] = "";
}

//INPUT import
if ($_POST["action"] == "import") {
	import($conn);
}


//Pages
include "visual/header.php";
include "visual/navbar.php";

if ($_GET["page"] == "worlds") {
 	include "visual/worlds.php";
	include "visual/worldstats.php";
} else {
	include "visual/main.php";
}

include "visual/footer.php";


