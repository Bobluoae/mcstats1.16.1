<?php 
//post and get functions to not have to do isset everytime
function post($name){
	if (!isset($_POST[$name])) {
		return "";
	}
	return $_POST[$name];
}
function get($name){
	if (!isset($_GET[$name])) {
		return "";
	}
	return $_GET[$name];
}

if (!isset($_SESSION["path"])) {
	$_SESSION["path"] = "";
}

//error handling
$message = "";
$error = false;

//Load a directory from path specified by user
function laddaDirectory($dir){
	
	$directory = array();

	// Check if the path is a directory
	if (is_dir($dir)) {

		//Open the directory
	    if ($dh = opendir($dir)) {

	    	//Loop through the directory and while it contains files, read directory of all files
	        while (($entry = readdir($dh)) !== false) {

	        	if (substr($entry, 0, 1) !== ".") {
	        		$directory[] = $entry;
	        	}
	        }
	        //Close accessed directory
	        closedir($dh);
	    }
	}
	return $directory;
}

//Get all statistics from path
function getStats($aPathfile){

	//Decode statistics json file
	$file = file_get_contents($aPathfile);
	$j = json_decode($file);

	$stats = array();

	//If json has stats
	if (isset($j->stats)) {
			
		//loop through every statistic and replace minecraft: with a /  
		foreach ($j->stats as $mainkey => $mainvalue) {

			foreach ($mainvalue as $key => $value) {
				$keyname = $mainkey . "" . $key;
				$keyname = str_replace("minecraft:", "/", $keyname);
				$stats[$keyname] = $value;
			}
		}
		//Return all statistics
		return $stats;
	} else {
		return false;
	}	
}