<?php

declare(strict_types=1);

namespace Rushil13579\AdvancedLeaderboards;

use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\{FloatTag,CompoundTag};
use pocketmine\network\mcpe\protocol\SetActorDataPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;

/**
 * Trait containing methods used in various Slappers.
 */
trait ALEntityTrait {
    /** @var CompoundTag */
    public $namedtag;

    /**
     * @return DataPropertyManager
     */
    abstract public function getNetworkProperties(): DataPropertyManager;

    /**
     * @return string
     */
    abstract public function getNameTag(): string;

    abstract public function sendNameTag(Player $player): void;

    abstract public function setGenericFlag(int $flag, bool $value = true): void;

    public function prepareMetadata(): void {
        $this->setGenericFlag(Entity::DATA_FLAG_IMMOBILE, true);
        if (!$this->namedtag->hasTag("Scale", FloatTag::class)) {
            $this->namedtag->setFloat("Scale", 1.0, true);
        }
        $this->getNetworkProperties()->setFloat(Entity::DATA_SCALE, $this->namedtag->getFloat("Scale"));
    }

    public function tryChangeMovement(): void {

    }

    public function sendData($playerList, array $data = null): void {
        if(!is_array($playerList)){
            $playerList = [$playerList];
        }

        foreach($playerList as $p){
            $playerData = $data ?? $this->getNetworkProperties()->getAll();
            unset($playerData[self::DATA_NAMETAG]);
            $pk = new SetActorDataPacket();
            $pk->entityRuntimeId = $this->getId();
            $pk->metadata = $playerData;
            $p->dataPacket($pk);

            $this->sendNameTag($p);
        }
    }

    public function saveALEntityNbt(): void {
        $visibility = 0;
        if ($this->isNameTagVisible()) {
            $visibility = 1;
            if ($this->isNameTagAlwaysVisible()) {
                $visibility = 2;
            }
        }
        $scale = $this->getNetworkProperties()->getFloat(Entity::DATA_SCALE);
        $this->namedtag->setInt("NameVisibility", $visibility, true);
        $this->namedtag->setFloat("Scale", $scale, true);
    }

    public function getDisplayName(Player $player): string {
        $vars = [
            "{name}" => $player->getName(),
            "{display_name}" => $player->getName(),
            "{nametag}" => $player->getNameTag()
        ];
        return str_replace(array_keys($vars), array_values($vars), $this->getNameTag());
    }
}
