<?php

namespace Rushil13579\AdvancedLeaderboards\Tasks;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;

use Rushil13579\AdvancedLeaderboards\Main;

class LeaderboardUpdateTask extends Task {

    private Main $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function onRun(): void{
        foreach($this->main->getServer()->getWorldManager()->getWorlds() as $level){
            foreach($level->getEntities() as $entity){
                if($this->main->isALEntity($entity) !== null){
                    $type = $this->main->typeOfALEntity($entity);
                    $this->main->updateLeaderboard($entity, $type);
                }
            }
        }
    }
}
