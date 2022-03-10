<?php 
include "db/database.php";
include "logic/functions.php";
include "logic/import.php";
//Pages
include "visual/header.php";
include "visual/navbar.php";
//ISSET
// if (!isset($_GET["page"])) {
//     $_GET["page"] = "";
// }
// if (!isset($_GET["worlds"])) {
// 	$_GET["worlds"] = "";
// }
// if (!isset($_GET["groups"])) {
// 	$_GET["groups"] = "";
// }
// if (!isset($_GET[""])) {
// 	$_GET[""] = "";
// }
// if (!isset($_POST["action"])) {
// 	$_POST["action"] = "";
//}



//INPUT import
if (post("action") == "import") {
	import($conn);
}
// //INPUT import
// if ($_POST["action"] == "import") {
// 	import($conn);
// }




if (get("page") == "worlds") {
 	include "visual/worlds.php";
	include "visual/worldstats.php";
} else {
	include "visual/main.php";
}

include "visual/footer.php";


