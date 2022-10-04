<?php

namespace Rushil13579\AdvancedLeaderboards\Tasks;

use pocketmine\{
    Server,
    Player
};

use pocketmine\scheduler\Task;

use Rushil13579\AdvancedLeaderboards\Main;

class OnlineTimeUpdateTask extends Task {

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function onRun($tick){
        foreach($this->main->getServer()->getOnlinePlayers() as $player){
            $this->main->updateOnlineTime($player);
        }
    }
}