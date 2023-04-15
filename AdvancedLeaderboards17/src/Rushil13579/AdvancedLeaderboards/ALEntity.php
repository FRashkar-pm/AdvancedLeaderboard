<?php

declare(strict_types=1);

namespace Rushil13579\AdvancedLeaderboards;

use pocketmine\player\Player;
use pocketmine\entity\{Skin,Human, Entity};
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\network\mcpe\protocol\SetActorDataPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataTypes;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use Rushil13579\AdvancedLeaderboards\Main;
use Rushil13579\AdvancedLeaderboards\ALEntityTrait;

class ALEntity extends Human {

    use ALEntityTrait;

    public $height = 0.0;
    public $width = 0.0;

    public function saveNBT(): CompoundTag {
        $nbt = parent::saveNBT();
        $visibility = 0;
        if ($this->isNameTagVisible()) {
            $visibility = 1;
            if ($this->isNameTagAlwaysVisible()) {
                $visibility = 2;
            }
        }
        $scale = $this->getNetworkProperties()->getFloat(EntityMetadataProperties::SCALE);
        $nbt->setInt("NameVisibility", $visibility, true);
        $nbt->setFloat("Scale", $scale, true);
        return $nbt;
    }

    public function sendNameTag(Player $player): void {
        $pk = new SetActorDataPacket();
        $pk->actorRuntimeId = $this->getId();
        $pk->metadata = [EntityMetadataProperties::NAMETAG => [EntityMetadataTypes::STRING , $this->getDisplayName($player)]];
        $player->getNetworkSession()->sendDataPacket($pk);
    }

    protected function sendSpawnPacket(Player $player): void {
        parent::sendSpawnPacket($player);
    }
}
