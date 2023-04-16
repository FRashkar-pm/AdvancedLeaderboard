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
use pocketmine\network\mcpe\protocol\types\entity\FloatMetadataProperty;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use Rushil13579\AdvancedLeaderboards\Main;
use Rushil13579\AdvancedLeaderboards\ALEntityTrait;

class ALEntity{

    use ALEntityTrait;
    
    public const DATA_NAMETAG = EntityMetadataProperties::NAMETAG;
    public const DATA_TYPE_STRING = EntityMetadataTypes::STRING;
    
    public $nametag = "";

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
        $scale = [EntityMetadataProperties::SCALE => new FloatMetadataProperty(0.0)];
        //$scale = $this->getNetworkProperties()->setFloat(EntityMetadataProperties::SCALE, 0.0, true);
        $nbt->setInt("NameVisibility", $visibility);
        $nbt->setFloat("Scale", $scale);
        return $nbt;
    }

    public function sendNameTag(Player $player): void {
        $pk = new SetActorDataPacket();
        $pk->actorRuntimeId = $this->getId();
        $pk->metadata = [self::DATA_NAMETAG => self::DATA_TYPE_STRING, $this->getPlayerDisplayName($player)];
        $player->getNetworkSession()->sendDataPacket($pk);
    }

    protected function sendSpawnPacket(Player $player): void {
        parent::sendSpawnPacket($player);
    }
}
