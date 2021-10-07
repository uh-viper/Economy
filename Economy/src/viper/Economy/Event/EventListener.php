<?php

namespace viper\Economy\Event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use viper\Economy\EconomyManager;

class EventListener implements Listener{
    public function onJoin(PlayerJoinEvent $event){
        $name = $event->getPlayer()->getName();
        if(EconomyManager::getInstance()->getBalance($name) == null){
            EconomyManager::getInstance()->setBalance($name, 500);
        }
    }
}