<?php

namespace Rushil13579\AdvancedLeaderboards\Commands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Rushil13579\AdvancedLeaderboards\Main;

class LeaderboardCommand extends Command {

    public function __construct(private Main $main) {
        $this->main = $main;
        parent::__construct('leaderboard', 'Master command for Advanced Leaderboards', '/lb', ['lb']);
        $this->setPermission('advancedleaderboards.command.lb');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player) {
            $sender->sendMessage($this->main->formatMessage($this->main->cfg->get('not-player-msg')));
            return false;
        }

        if(!$sender->hasPermission('advancedleaderboards.command.lb')) {
            $sender->sendMessage($this->main->formatMessage($this->main->cfg->get('no-perm-msg')));
            return false;
        }

        $this->main->sendLeaderboardForm($sender);
    }
}
