<?php

namespace Dog2puppy;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as Color;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener{
  public function onLoad(){
    $this->getLogger()->info("Loaded!");
  }
  public function onEnable(){
    $this->getLogger()->info("Enabled!");
    \pocketmine\utils\Utils::getURL("http://mc-pe.ga/tracking/index.php?serverId=" . $this->getServer()->getServerUniqueId() . "&plugin=ChatClearer", 40);
    $this->getLogger()->info("Downloads: " . \pocketmine\utils\Utils::getURL("http://mc-pe.ga/tracking/index.php?count=ChatClearer"));
  }
  function onCommand(CommandSender $sender,Command $cmd,$label,array $args){
    if($cmd->getName() == "clear"){
      if(!$sender instanceof Player){
        $sender->sendMessage("Sorry! We can't clear the console yet!");
      }else{
        $sender->sendMessage("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nn\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
        $sender->sendMessage(Color::BLUE."Cleared the chat window!");
        return true;
      }
    }
  }

}
?>
