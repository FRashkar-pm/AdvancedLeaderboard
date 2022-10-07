<?php

declare(strict_types=1);

namespace Rushil13579\AdvancedLeaderboards;

use pocketmine\Player;
use pocketmine\entity\{Skin,Human};
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\SetActorDataPacket;
use Rushil13579\AdvancedLeaderboards\Main;

class ALEntity extends Human {

    use ALEntityTrait;

    public $height = 0.0;
    public $width = 0.0;

    public function saveNBT(): void {
        parent::saveNBT();
        $this->saveALEntityNbt();
    }

    public function sendNameTag(Player $player): void {
        $pk = new SetActorDataPacket();
        $pk->entityRuntimeId = $this->getId();
        $pk->metadata = [self::DATA_NAMETAG => [self::DATA_TYPE_STRING, $this->getDisplayName($player)]];
        $player->dataPacket($pk);
    }

    protected function sendSpawnPacket(Player $player): void {
        parent::sendSpawnPacket($player);
    }
}
