<?php

namespace viper\Economy\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use viper\Economy\Command\SubCommands\GiveCommand;
use viper\Economy\Command\SubCommands\PayCommand;
use viper\Economy\Command\SubCommands\SetCommand;
use viper\Economy\Command\SubCommands\TakeCommand;

class EconomyCommand extends Command{

    public array $subCommands;

    public function __construct(){
        parent::__construct("money", "Usage of Economy commands");
        $this->registerSubCommands();
    }

    public function registerSubCommands(): void{
        $commands = [
            new TakeCommand(),
            new GiveCommand(),
            new SetCommand(),
            new PayCommand()
        ];
        foreach ($commands as $command) $this->subCommands[$command->getName()] = $command;
    }

    // Aliases are not included because they weren't used!
    public function getCommand(string $parameter): ?Command{
        return $this->subCommands[$parameter] ?? null;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player){
            if(empty($args[0]) or (!$this->getCommand($args[0]))){
                $sender->sendMessage(TextFormat::RESET . TextFormat::RED . "/money help");
                return;
            }
            $this->getCommand($args[0])?->execute($sender, $commandLabel, $args);
        }
    }
}