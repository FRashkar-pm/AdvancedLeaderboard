<?php

declare(strict_types=1);

namespace Rushil13579\AdvancedLeaderboards;

use pocketmine\player\Player;
use pocketmine\entity\{Skin,Human};
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\SetActorDataPacket;
use Rushil13579\AdvancedLeaderboards\Main;
use Rushil13579\AdvancedLeaderboards\ALEntityTrait;

class ALEntity extends Human {

    use ALEntityTrait;

    public $height = 0.0;
    public $width = 0.0;

    public function saveNBT(): CompoundTag {
        $nbt = parent::saveNBT();
        return $nbt;
    }

    public function sendNameTag(Player $player): void {
        $pk = new SetActorDataPacket();
        $pk->actorRuntimeId = $this->getId();
        $pk->metadata = [self::NAMETAG => [self::STRING , $this->getDisplayName($player)]];
        $player->getNetworkSession()->sendDataPacket($pk);
    }

    protected function sendSpawnPacket(Player $player): void {
        parent::sendSpawnPacket($player);
    }
}
