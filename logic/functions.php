<?php 

function laddaDirectory($dir){
	// Open a known directory, and proceed to read its contents
	$directory = array();
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	        while (($entry = readdir($dh)) !== false) {

	        	if (substr($entry, 0, 1) !== ".") {
	        		$directory[] = $entry;
	        	}
	            //. filetype($dir . $entry) . "\n";
	        }
	        closedir($dh);
	    }
	}
	return $directory;
}

function getStats($aPathfile){
	//echo nl2br(Read("C:\Users\Erik\AppData\Roaming\.minecraft\saves\New World\stats/71b8e290-9b39-4f4c-ae8f-2070a235d961.json"));
	$file = file_get_contents($aPathfile);
	$j = json_decode($file);

	$stats = array();

	if (isset($j->stats)) {
			# code...
		foreach ($j->stats as $mainkey => $mainvalue) {

			foreach ($mainvalue as $key => $value) {
				$keyname = $mainkey . "" . $key;
				$keyname = str_replace("minecraft:", "/", $keyname);
				$stats[$keyname] = $value;
			}
		}
		

		return $stats;
	} else {
		return false;
	}	
}