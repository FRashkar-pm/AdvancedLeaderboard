<?php

namespace Rushil13579\AdvancedLeaderboards\Tasks;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\scheduler\Task;

use Rushil13579\AdvancedLeaderboards\Main;

class LeaderboardUpdateTask extends Task {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onRun() : void {
        foreach(Server::getInstance()->getWorldManager()->getWorlds() as $worlds) {
            foreach($worlds->getEntities() as $entity) {
                if($this->main->isALEntity($entity) !== null) {
                    $type = $this->main->typeOfALEntity($entity);
                    $this->main->updateLeaderboard($entity, $type);
                }
            }
        }
    }
}