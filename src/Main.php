<?php
declare(strict_types=1);

namespace voidpvp\ffamap;

use pocketmine\plugin\PluginBase;
use Vecnavium\FormsUI\SimpleForm;
use Vecnavium\FormsUI\CustomForm;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ToolTier;
use pocketmine\item\enchantment;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\WorldLoadEvent;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\world\particle\BlockBreakParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener{
    public $PlayerList = [];
 public function selectPlayer($player){
 	$List = [];
     foreach($this->getServer()->getOnlinePlayers() as $p){
     	$List[] = $p->getName();
     }
     $this->PlayerList[$player->getName()] = $List;
 	$form = new CustomForm(function (Player $player, array $data){
 
      $index = $data[1];
      $PlayerName = $this->PlayerList[$player->getName()] [$index];
      $this->duel($player);
 });
 $form->setTitle("§3Duels invite");
 $form->addLabel("§3pls select a player to want to duels");
 $form->addDropdown("§bPls select all player to invite", $this->PlayerList[$player->getName()] );
 $player->sendForm($form);
 return $form;
}
public function duel($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->gladiator($player);
				break;
				
				case 2:
				$this->kungfu($player);
				break;
				
				case 3:
				$this->city($player);
				break;
	    }
    });
                 $form->setTitle("§bDuels Map selector");
    $form->setContent("§3Pls select a Duels Map");
    $form->addButton("§6Gladiators Map",0," textures/ui/gladiator");
$form->addButton("§6Kung Fu Arena Map",0,"textures/ui/city");
$form->addButton("§6Ancient City Map",0,"textures/ui/clock");
$player->sendForm($form);
}
public function gladiator($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			$duels1 = $this->getServer()->getWorldManager()->getWorldByName('duels1');
    $duels2 = $this->getServer()->getWorldManager()->getWorldByName('duels2');
     $duels3 = $this->getServer()->getWorldManager()->getWorldByName('duels3');
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'gladiator1');
				break;
				
				case 2:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'gladiator2');
				break;
				
				case 3:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'gladiator3');
				break;
				
				case 4:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'gladiator4');
				break;
	    }
    });
                 $form->setTitle("§bDuels Map selector");
    $form->setContent("§3Pls select an empty map");
    $form->addButton("§6Gladiators 1",0," textures/ui/gladiator");
    $form->addButton("§6Gladiators 2",0," textures/ui/gladiator");
    $form->addButton("§6Gladiators 3",0," textures/ui/gladiator");
    $form->addButton("§6Gladiators 4",0," textures/ui/gladiator");
$player->sendForm($form);
}
public function kungfu($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung1');
				break;
                                
                                case 2:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung2');
				break;

                                case 3:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung3');
				break;

                                case 4:
                                $this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung4');
                                break;

                                case 5:
                                $this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung5');
                                break;

                                case 6:
                                $this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung6');
                                break;

                                case 7:
                                $this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung7');
                                break;

                                case 8:
                                $this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'kung8');
                                break;
           }
    });
                 $form->setTitle("§bPls select a Empty Map");
$form->addButton("§6Kung Fu 1",0,"textures/ui/city");
$form->addButton("§6Kung Fu 2",0,"textures/ui/city");
$form->addButton("§6Kung Fu 3",0,"textures/ui/city");
$form->addButton("§6Kung Fu 4",0,"textures/ui/city");
$form->addButton("§6Kung Fu 5",0,"textures/ui/city");
$form->addButton("§6Kung Fu 6",0,"textures/ui/city");
$form->addButton("§6Kung Fu 7",0,"textures/ui/city");
$form->addButton("§6Kung Fu 8",0,"textures/ui/kung");
$player->sendForm($form);
}
public function city($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'city1');
				break;
                                
                                case 2:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'city2');
				break;

                                case 3:
				$this->getServer()->dispatchCommand($player, 'duel' .$this->PlayerList[$player->getName()]. 'city3');
				break;
}
    });
                 $form->setTitle("§bPls select a Empty Map");
$form->addButton("§6City 1",0,"textures/ui/city");
$form->addButton("§6City 2",0,"textures/ui/city");
$form->addButton("§6City 3",0,"textures/ui/city");
$player->sendForm($form);
}
      
      public function onEnable(): void{
   
	$this->getServer()->getPluginManager()->registerEvents($this, $this);
	$this->getLogger()->info("what is your problem");
	if($this->getServer()->getWorldManager()->isWorldLoaded('duels1')){
      }else{
       $this->getServer()->getWorldManager()->LoadWorld('duels1');
      } 
       if($this->getServer()->getWorldManager()->isWorldLoaded('duels2')){
      }else{
       $this->getServer()->getWorldManager()->LoadWorld('duels2');
      } 
       if($this->getServer()->getWorldManager()->isWorldLoaded('duels3')){
      }else{
       $this->getServer()->getWorldManager()->LoadWorld('duels3');
      } 
      if($this->getServer()->getWorldManager()->isWorldLoaded('Arena')){
      }else{
       $this->getServer()->getWorldManager()->LoadWorld('Arena');
      } 
}

      public function onCommand(CommandSender $sender, Command $command,string $label, array $args): bool{
        switch($command->getName()){
        case "ffamap":
            $this->fFa($sender);
        case "dmap":
           $this->duels($sender);
        case "gladiator":
           $this->gladiator1($sender);
        case "kungfu":
           $this->kungfu1($sender);
        case "city1":
           $this->city1($sender);
        }
        return true;
    }
      public function fFa($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			$mars1 = $this->getServer()->getWorldManager()->getWorldByName('newarena');
    $biomic1 = $this->getServer()->getWorldManager()->getWorldByName('ffa');
     $stadium1 = $this->getServer()->getWorldManager()->getWorldByName('collosium');
     $market1 = $this->getServer()->getWorldManager()->getWorldByName('Arenas');
			switch($data){
				case 0:
				$player->teleport($mars1->getSafeSpawn());
				break;
				
				case 1:
				$player->teleport($biomic1->getSafeSpawn());
				break;
				
				case 2:
				$player->teleport($stadium1->getSafeSpawn());
				break;
				
				case 3:
				$player->teleport($market1->getSafeSpawn());
				break;
	        }
	    
    });
  $mars = count($this->getServer()->getWorldManager()->getWorldByName('newarena')->getPlayers());
       $biomic = count($this->getServer()->getWorldManager()->getWorldByName('ffa')->getPlayers());
             $stadium = count($this->getServer()->getWorldManager()->getWorldByName('collosium')->getPlayers());
               $Market = count($this->getServer()->getWorldManager()->getWorldByName('Arenas')->getPlayers());
                 $form->setTitle("§bFFA Map selector");
    $form->setContent("§3Pls select a FFA Map");
    $form->addButton("§6Stadium Map \n §bPlayers[{$stadium}],0,textures/items/stadium");
$form->addButton("§6Mars Map \n §bPlayers[{$mars}],0,textures/items/mars");
$form->addButton("§6boimic Map \n §b[{$biomic}],0,textures/items/biome");$form->addButton("§6Market Map \n §bPlayers[{$Market}],0,textures/items/market");
$player->sendForm($form);
}
public function duels($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
     $duels1 = $this->getServer()->getWorldManager()->getWorldByName('duels1');
     $duels2 = $this->getServer()->getWorldManager()->getWorldByName('duels2');
     $duels3 = $this->getServer()->getWorldManager()->getWorldByName('duels3');
			switch($data){
				case 1:
				$player->teleport($duels1->getSafeSpawn());
				break;
				
				case 2:
				$player->teleport($duels2->getSafeSpawn());
				break;
				
				case 3:
				$player->teleport($duels3->getSafeSpawn());
				break;
	    }
    });
                 $form->setTitle("§bDuels Map selector");
    $form->setContent("§3Pls select a Duels Map");
    $form->addButton("§6Gladiators Map",0," textures/ui/gladiator");
$form->addButton("§6Kung Fu Arena Map",0,"textures/ui/kung");
$form->addButton("§6Ancient City Map",0,"textures/ui/city");
$player->sendForm($form);
}
public function gladiator1($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand($player, "duel queue gladiator1");
				break;
				
				case 2:
				$this->getServer()->dispatchCommand($player, "duel queue gladiator2");
				break;
				
				case 3:
				$this->getServer()->dispatchCommand($player, "duel queue gladiator3");
				break;
				
				case 4:
				$this->getServer()->dispatchCommand($player, "duel queue gladiator4");
				break;
	    }
    });
                 $form->setTitle("§bDuels Map selector");
    $form->setContent("§3Pls select an empty map");
    $form->addButton("§6Gladiators 1",0," textures/ui/one");
    $form->addButton("§6Gladiators 2",0," textures/ui/two");
    $form->addButton("§6Gladiators 3",0," textures/ui/three");
    $form->addButton("§6Gladiators 4",0," textures/ui/four");
$player->sendForm($form);
}
public function kungfu1($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand("duel queue kung1");
				break;
                                
                                case 2:
				$this->getServer()->dispatchCommand("duel queue kung2");
				break;

                                case 3:
				$this->getServer()->dispatchCommand("duel queue kung3");
				break;

                                case 4:
                                $this->getServer()->dispatchCommand("duel queue kung4");
                                break;

                                case 5:
                                $this->getServer()->dispatchCommand("duel queue kung5");
                                break;

                                case 6:
                                $this->getServer()->dispatchCommand("duel queue kung6");
                                break;

                                case 7:
                                $this->getServer()->dispatchCommand("duel queue kung7");
                                break;

                                case 8:
                                $this->getServer()->dispatchCommand("duel queue kung8");
                                break;
           }
    });
                 $form->setTitle("§bPls select a Empty Map");
$form->addButton("§6Kung Fu 1",0,"textures/ui/one");
$form->addButton("§6Kung Fu 2",0,"textures/ui/two");
$form->addButton("§6Kung Fu 3",0,"textures/ui/three");
$form->addButton("§6Kung Fu 4",0,"textures/ui/four");
$form->addButton("§6Kung Fu 5",0,"textures/ui/five");
$form->addButton("§6Kung Fu 6",0,"textures/ui/six");
$form->addButton("§6Kung Fu 7",0,"textures/ui/seven");
$form->addButton("§6Kung Fu 8",0,"textures/ui/eight");
$player->sendForm($form);
}
public function city1($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand($player, "duel queue city1");
				break;
                                
                                case 2:
				$this->getServer()->dispatchCommand($player, "duel queue city2");
				break;

                                case 3:
				$this->getServer()->dispatchCommand($player, "duel queue city3");
				break;
}
    });
                 $form->setTitle("§bPls select a Empty Map");
$form->addButton("§6City 1",0,"textures/ui/one");
$form->addButton("§6City 2",0,"textures/ui/two");
$form->addButton("§6City 3",0,"textures/ui/three");
$player->sendForm($form);
}
}
