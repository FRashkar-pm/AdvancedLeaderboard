<?php

namespace Rushil13579\AdvancedLeaderboards\Tasks;

use pocketmine\{
    Server,
    Player
};

use pocketmine\scheduler\Task;

use Rushil13579\AdvancedLeaderboards\Main;

class LeaderboardUpdateTask extends Task {

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function onRun($tick){
        foreach($this->main->getServer()->getLevels() as $level){
            foreach($level->getEntities() as $entity){
                if($this->main->isALEntity($entity) !== null){
                    $type = $this->main->typeOfALEntity($entity);
                    $this->main->updateLeaderboard($entity, $type);
                }
            }
        }
    }
}