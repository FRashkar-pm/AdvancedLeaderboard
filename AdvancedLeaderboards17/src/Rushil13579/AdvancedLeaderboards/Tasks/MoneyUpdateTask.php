<?php

namespace Rushil13579\AdvancedLeaderboards\Tasks;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\scheduler\Task;

use Rushil13579\AdvancedLeaderboards\Main;

class MoneyUpdateTask extends Task {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onRun() : void {
        foreach(Server::getInstance()->getOnlinePlayers() as $player) {
            $this->main->updateMoney($player);
        }
    }
}