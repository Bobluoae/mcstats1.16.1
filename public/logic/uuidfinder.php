<?php
class UuidFinder
{
    public function __construct($statsPath = "stats") {
        $this->statsPath = $statsPath;


        $playerFiles = laddaDirectory($statsPath);

        $playerData = [];
        $uuids = [];

        foreach ($playerFiles as &$file) {

            $uuid = str_replace("-","",substr($file, 0, -5));
            $this->uuids =+ $uuid;

            $url = "https://playerdb.co/api/player/minecraft/".$uuid;

            $playerjson = file_get_contents($url);
            $metadata = json_decode($playerjson);

            $playerData[$uuid]["url"] = $url;
            $playerData[$uuid]["file"] = $file;
            $playerData[$uuid]["name"] = $metadata->data->player->username;
            $playerData[$uuid]["metadata"] = $metadata;


        }
        $this->playerData = $playerData;
    }
/*    public function getPlayerNames() {
        return $this->playerData[$uuids[0]];

    }*/
}


//pseudo code
/*
    stats FOLDER location
    read stat file name once per file(player) statistic and group into different idk variables?






    TODO:
    Rework the SQL input so its more optimized


*/
