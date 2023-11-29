<div class="content">
	<!-- navbar -->

    <?php
    $uuid = "71b8e290-9b39-4f4c-ae8f-2070a235d961";
    $url = "https://playerdb.co/api/player/minecraft/".str_replace("-","",$uuid);

    $playerjson = file_get_contents($url);
    $metadata = json_decode($playerjson);

    $name = $metadata->data->player->username;

    echo $name;

    //$uuiddir = $_SESSION["path"] ."/". $world ."/stats/";
    //echo $uuiddir;
    ?>
<ul>
	<li><a href="index.php">Main</a> <br></li>
	<li><a href="index.php?page=worlds">World</a></li>
</ul>
