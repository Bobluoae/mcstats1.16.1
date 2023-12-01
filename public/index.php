<?php
session_start();
include "db/database.php";
include "logic/functions.php";
include "logic/import.php";
include "logic/uuidfinder.php";

// $players = new UuidFinder();

//Call to function named import when button is pressed to read import all data into database
if (post("action") == "import") {
	import($conn);
}

//Always visible on page
include "visual/header.php";
include "visual/navbar.php";

//Page handler
if (get("page") == "worlds") {
	include "visual/worldstats.php";
} else {
	include "visual/main.php";
}

//Footer always visible on page
include "visual/footer.php";
