<?php

namespace viper\Economy;

use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use viper\Economy\Command\EconomyCommand;
use viper\Economy\Event\EventListener;
use viper\Loader;

class EconomyManager{

    use SingletonTrait;

    const INVALID_PERMISSIONS = TextFormat::RESET . TextFormat::RED . "You do not have permission to use this.";

    public function getPath(): string{
        return Loader::getInstance()->getDataFolder();
    }

    public function register(){
        Server::getInstance()->getCommandMap()->register("Economy", new EconomyCommand());
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener(), Loader::getInstance());
        EconomyManager::getInstance()->createFile();
    }

    public function createFile(){
        if(!file_exists($this->getPath() . "Money.yml")) {
            fopen($this->getPath() . "Money.yml", "w");
        }
    }

    public function getBalance(string $name): ?int{
        return yaml_parse_file($this->getPath() . "Money.yml")[$name] ?? null;
    }

    public function setBalance(string $name, int $amount): void{
        yaml_emit_file($this->getPath() . "Money.yml", [$name => $amount]);
    }

    public function addToBalance(string $name, int $amount): void{
        $this->setBalance($name, $this->getBalance($name) + $amount);
    }

    public function takeFromBalance(string $name, int $amount): void{
        $this->setBalance($name, $this->getBalance($name) - $amount);
    }
}