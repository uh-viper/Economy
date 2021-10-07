<?php

namespace viper;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use viper\Economy\EconomyManager;

class Loader extends PluginBase{

    use SingletonTrait;

    public function onLoad(): void{
        self::setInstance($this);
    }

    public function onEnable(): void{
        EconomyManager::getInstance()->register();
    }
}