<?php
namespace maru;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use ifteam\TAGBlock\TAGSystem;
use pocketmine\level\Position;

class WordBallon extends PluginBase implements Listener {
	
	public $config;
	
	public function onEnable() {
		$this->LoadConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function LoadConfig() {
		$this->saveResource("config.yml");
		$this->config = (new Config($this->getDataFolder()."config.yml", Config::YAML))->getAll();
	}
	public function onChat(PlayerChatEvent $event) {
		$player = $event->getPlayer();
		$message = "<{$player->getName()}> : {$event->getMessage()}";
		if($this->config["show-chat"] == false) {
			$event->setCancelled();
		}
		$pos = new Position($player->getX(), $player->getY()+3, $player->getZ(), $player->getLevel());
		TAGSystem::getInstance()->addInstanceTag($pos, $message, $this->config["show-time"] * 20);
	}
}
?>
