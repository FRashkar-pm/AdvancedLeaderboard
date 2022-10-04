<?php

namespace Rushil13579\AdvancedLeaderboards\Commands;

use pocketmine\{
    Server,
    Player
};

use pocketmine\command\{
    Command,
    CommandSender
};

use Rushil13579\AdvancedLeaderboards\Main;

class LeaderboardCommand extends Command {

    private $main;

    public function __construct(Main $main){
        $this->main = $main;

        parent::__construct('leaderboard', 'Master command for Advanced Leaderboards', '/lb', ['lb']);
        $this->setPermission('advancedleaderboards.command.lb');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage($this->main->formatMessage($this->main->cfg->get('not-player-msg')));
            return false;
        }

        if(!$sender->hasPermission('advancedleaderboards.command.lb')){
            $sender->sendMessage($this->main->formatMessage($this->main->cfg->get('no-perm-msg')));
            return false;
        }

        $this->main->sendLeaderboardForm($sender);
    }
}
