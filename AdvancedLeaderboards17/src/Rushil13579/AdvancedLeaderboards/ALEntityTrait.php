<?php

declare(strict_types=1);

namespace Rushil13579\AdvancedLeaderboards;

use pocketmine\player\Player;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\{FloatTag,CompoundTag};
use pocketmine\network\mcpe\protocol\SetActorDataPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataFlags;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;

/**
 * Trait containing methods used in various Slappers.
 */
trait ALEntityTrait {
    /** @var CompoundTag */
    public CompoundTag $namedtag;

    /**
     * @return DataPropertyManager
     */
    abstract public function getNetworkProperties(): EntityMetadataCollection;

    /**
     * @return string
     */
    abstract public function getNameTag(): string;

    abstract public function sendNameTag(Player $player): void;

    //abstract public function setGenericFlag(int $flag, bool $value = true): void;

    public function prepareMetadata(): void {
        $this->getNetworkProperties()->setGenericFlag(EntityMetadataFlags::IMMOBILE, true);
        if (!$this->namedtag->getTag("Scale") instanceof FloatTag) {
            $this->namedtag->setFloat("Scale", 1.0);
        }
        $this->getNetworkProperties()->setFloat(EntityMetadataProperties::SCALE, $this->namedtag->getFloat("Scale"));
    }

    /*public function tryChangeMovement(): void {

    }*/

    public function sendData($playerList, array $data = null): void {
        if(!is_array($playerList)){
            $playerList = [$playerList];
        }

        foreach($playerList as $p){
            $playerData = $data ?? $this->getNetworkProperties()->getAll();
            unset($playerData[self::NAMETAG]);
            $pk = new SetActorDataPacket();
            $pk->actorRuntimeId = $this->getId();
            $pk->metadata = $playerData;
            $p->getNetworkSession()->sendDataPacket($pk);

            $this->sendNameTag($p);
        }
    }

    /*public function saveALEntityNbt(): void {
        $visibility = 0;
        if ($this->isNameTagVisible()) {
            $visibility = 1;
            if ($this->isNameTagAlwaysVisible()) {
                $visibility = 2;
            }
        }
        $scale = $this->getNetworkProperties()->getFloat(EntityMetadataProperties::SCALE);
        $this->namedtag->setInt("NameVisibility", $visibility, true);
        $this->namedtag->setFloat("Scale", $scale, true);
    }*/

    public function getDisplayName(Player $player): string {
        $vars = [
            "{name}" => $player->getName(),
            "{display_name}" => $player->getName(),
            "{nametag}" => $player->getNameTag()
        ];
        return str_replace(array_keys($vars), array_values($vars), $this->getNameTag());
    }
}
