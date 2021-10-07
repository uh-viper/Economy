<?php

namespace viper\Economy\Command\SubCommands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use viper\Economy\EconomyManager;

class SetCommand extends Command{
    public function __construct(){
        parent::__construct("set");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player){
            if(!$sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                $sender->sendMessage(EconomyManager::INVALID_PERMISSIONS);
                return;
            }
            if(empty($args[1]|$args[2])){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "/money give [player] [amount]");
                return;
            }
            if(EconomyManager::getInstance()->getBalance($args[1]) == null){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "This player does not exist! Please enter their full-name");
                return;
            }
            EconomyManager::getInstance()->setBalance($args[1], $args[2]);
            $sender->sendMessage(TextFormat::RESET . TextFormat::GREEN . "You have set" . " " . $args[1] . "'s " . "balance to" . " " . number_format($args[2]));
        }
    }
}