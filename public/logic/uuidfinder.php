<?php
class UuidFinder
{
    public function __construct($statsPath = "stats") {
        $this->statsPath = $statsPath;


        $playerFiles = laddaDirectory($statsPath);

        $playerData = [];

        foreach ($playerFiles as &$file) {
            $uuid = str_replace("-","",substr($file, 0, -5));

            $url = "https://playerdb.co/api/player/minecraft/".$uuid;

            $playerjson = file_get_contents($url);
            $metadata = json_decode($playerjson);

            $playerData[$uuid]["url"] = $url;
            $playerData[$uuid]["file"] = $file;
            $playerData[$uuid]["name"] = $metadata->data->player->username;
            $playerData[$uuid]["metadata"] = $metadata;

        }
        var_dump($playerData);
        die();

       // $url = "https://playerdb.co/api/player/minecraft/".str_replace("-","",$uuid);

        // $playerjson = file_get_contents($url);
        // $metadata = json_decode($playerjson);

        // $name = $metadata->data->player->username;


    }
}


//pseudo code
/*
    stats FOLDER location
    read stat file name once per file(player) statistic and group into different idk variables?






    TODO:
    Rework the SQL input so its more optimized


*/
