<?php

namespace viper\Economy\Command\SubCommands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use viper\Economy\EconomyManager;

class PayCommand extends Command{
    public function __construct(){
        parent::__construct("pay");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player){
            if(empty($args[1]|$args[2])){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "/money pay [player] [amount]");
                return;
            }
            if($sender->getName() == $args[1]){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "You cannot pay yourself.");
                return;
            }
            if(EconomyManager::getInstance()->getBalance($sender->getName()) < $args[2]){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "You do not have enough money to pay the amount you disclosed.");
                return;
            }
            if(EconomyManager::getInstance()->getBalance($args[1]) == null){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "The player you wish to pay does not exist! Please enter their whole name.");
                return;
            }
            EconomyManager::getInstance()->takeFromBalance($sender->getName(), $args[2]);
            EconomyManager::getInstance()->addToBalance($args[1], $args[2]);
            $sender->sendMessage(TextFormat::RESET . TextFormat::GREEN . "You paid" . " " . $args[1] . " " . number_format($args[2]));
            Server::getInstance()->getPlayerExact($args[1])?->sendMessage(TextFormat::RESET . TextFormat::GREEN . "You were paid " . number_format($args[2]) . " " . "from" . " " . $sender->getName());
        }
    }
}