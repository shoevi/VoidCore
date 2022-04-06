<?php
declare(strict_types=1);

namespace voidpvp\ffamap;

use pocketmine\plugin\PluginBase;
use Vecnavium\FormsUI\SimpleForm;
use Vecnavium\FormsUI\CustomForm;
use pocketmine\player\Player;
use pocketmine\Server;
use JavierLeon9966\ProperDuels\ProperDuels;
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
   public $PlayerList;
 public function selectPlayer($player){
    $List = [];
     foreach($this->getServer()->getOnlinePlayers() as $p){
     	$List[] = $p->getName();
     }
     $form = new CustomForm(function (Player $player, $data) use ($List) {
          if($data === null){
           return true;
          }
      $index = $data[1];
      $this->PlayerList = $List[$index];
      $this->duel($player);
 });
 $form->setTitle("§3Duels invite");
 $form->addLabel("§3pls select a player to want to duels");
 $form->addDropdown("§bPls select a player to invite", $List);
 $player->sendForm($form);
 return $form;
}
public function duel($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
                     return true;
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
    $form->addButton("§6Gladiators Map");
$form->addButton("§6Kung Fu Arena Map");
$form->addButton("§6Ancient City Map");
$player->sendForm($form);
}
public function gladiator($player){
 $Plyer = $this->PlayerList;
 $properDuels = ProperDuels::getInstance();
                    $sessionManager = $properDuels->getSessionManager();
                    $session = $sessionManager->get($Plyer);
                         if($session === null){
                               $sessionManager->add($Plyer);
                               $session = $sessionManager->get($Plyer->getUniqueId()->getBytes());
                           }
                    $otherSession = $sessionManager->get($player->getUniqueId()->getBytes());
                          if($otherSession === null){
                                   $sessionManager->add($player);
                                   $otherSession = $sessionManager->get($player->getUniqueId()->getBytes());
                            }

	$form = new SimpleForm(function (Player $player, int $data = null) use ($session, $otherSession, $properDuels) {
		if($data === null){
                }
                    
                    
			switch($data){
				case 1:
				 $session->addInvite($otherSession, $properDuels->getArenaManager()->get('gladiator1'));
				break;
				
				case 2:
				 $session->addInvite($otherSession, $properDuels->getArenaManager()->get('gladiator2'));
				break;
				
				case 3:
				 $session->addInvite($otherSession, $properDuels->getArenaManager()->get('gladiator3'));
				break;
				
				case 4:
				 $session->addInvite($otherSession, $properDuels->getArenaManager()->get('gladiator4'));
				break;
	    }
    });
    $properDuels = ProperDuels::getInstance();
$arenag1 = $properDuels->getArenaManager()->get('gladiator1');
if($arenag1 === null){
    $g1 = "Arena 'gladiator1' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator1')){
    $g1 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag1){
    $g1 = "1/2 Players. you can join";
}else{
    $g1 = "Arena empty";
}
$arenag2 = $properDuels->getArenaManager()->get('gladiator2');
if($arenag2 === null){
    $g2 = "Arena 'gladiator2' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator2')){
    $g2 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag2){
    $g2 = "1/2 Players. you can join";
}else{
    $g2 = "Arena empty";
}
$arenag3 = $properDuels->getArenaManager()->get('gladiator3');
if($arenag3 === null){
    $g3 = "Arena 'gladiator3' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator3')){
    $g3 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag3){
    $g3 = "1/2 Players. you can join";
}else{
    $g3 = "Arena empty";
}
$arenag4 = $properDuels->getArenaManager()->get('gladiator4');
if($arenag4 === null){
    $g4 = "Arena 'gladiator4' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator4')){
    $g4 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag4){
    $g4 = "1/2 Players. you can join";
}else{
    $g4 = "Arena empty";
}
                 $form->setTitle("§bDuels Map selector");
    $form->setContent("§3Pls select an empty map");
    $form->addButton("§6Gladiators 1 /n {$g1}");
    $form->addButton("§6Gladiators 2 /n {$g2}");
    $form->addButton("§6Gladiators 3 /n {$g3}");
    $form->addButton("§6Gladiators 4 /n {$g4}");
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
    $properDuels = ProperDuels::getInstance();
$arenak1 = $properDuels->getArenaManager()->get('kung1');
if($arenak1 === null){
    $g1 = "Arena 'kung1' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung1')){
    $g1 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak1){
    $g1 = "1/2 Players. you can join";
}else{
    $g1 = "Arena empty";
}
$arenak2 = $properDuels->getArenaManager()->get('kung2');
if($arenak2 === null){
    $g2 = "Arena 'kung2' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung2')){
    $g2 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak2){
    $g2 = "1/2 Players. you can join";
}else{
    $g2 = "Arena empty";
}
$arenak3 = $properDuels->getArenaManager()->get('kung3');
if($arenak3 === null){
    $g3 = "Arena 'kung3' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung3')){
    $g3 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak3){
    $g3 = "1/2 Players. you can join";
}else{
    $g3 = "Arena empty";
}
$arenak4 = $properDuels->getArenaManager()->get('kung4');
if($arenak4 === null){
    $g4 = "Arena 'kung4' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung4')){
    $g4 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak4){
    $g4 = "1/2 Players. you can join";
}else{
    $g4 = "Arena empty";
}
$properDuels = ProperDuels::getInstance();
$arenak5 = $properDuels->getArenaManager()->get('kung5');
if($arenak5 === null){
    $g5 = "Arena 'kung5' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung5')){
    $g5 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak5){
    $g5 = "1/2 Players. you can join";
}else{
    $g5 = "Arena empty";
}
$arenak6 = $properDuels->getArenaManager()->get('kung6');
if($arenak6 === null){
    $g6 = "Arena 'kung6' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung6')){
    $g6 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak6){
    $g6 = "1/2 Players. you can join";
}else{
    $g6 = "Arena empty";
}
$arenak7 = $properDuels->getArenaManager()->get('kung7');
if($arenak7 === null){
    $g7 = "Arena 'kung7' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung7')){
    $g7 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak7){
    $g7 = "1/2 Players. you can join";
}else{
    $g7 = "Arena empty";
}
$form->setTitle("§bPls select a Empty Map");
$form->addButton("§6Kung Fu 1 \n {$g1}");
$form->addButton("§6Kung Fu 2 \n {$g2}");
$form->addButton("§6Kung Fu 3 \n {$g3}");
$form->addButton("§6Kung Fu 4 \n {$g4}");
$form->addButton("§6Kung Fu 5 \n {$g5}");
$form->addButton("§6Kung Fu 6 \n {$g6}");
$form->addButton("§6Kung Fu 7 \n {$g7}");
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
    $properDuels = ProperDuels::getInstance();
$arenac1 = $properDuels->getArenaManager()->get('city1');
if($arenac1 === null){
    $g1 = "Arena 'city1' doesn't exists";
}elseif($properDuels->getGameManager()->has('city1')){
    $g1 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenac1){
    $g1 = "1/2 Players. you can join";
}else{
    $g1 = "Arena empty";
}
$arenac2 = $properDuels->getArenaManager()->get('city2');
if($arenac2 === null){
    $g2 = "Arena 'city2' doesn't exists";
}elseif($properDuels->getGameManager()->has('city2')){
    $g2 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenac2){
    $g2 = "1/2 Players. you can join";
}else{
    $g2 = "Arena empty";
}
$arenac3 = $properDuels->getArenaManager()->get('city3');
if($arenac3 === null){
    $g3 = "Arena 'city3' doesn't exists";
}elseif($properDuels->getGameManager()->has('city3')){
    $g3 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenac3){
    $g3 = "1/2 Players. you can join";
}else{
    $g3 = "Arena empty";
}
                 $form->setTitle("§bPls select a Empty Map");
$form->addButton("§6City 1 \n {$g1}");
$form->addButton("§6City 2 \n {$g2}");
$form->addButton("§6City 3 \n {$g3}");
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
        case "dselector":
           $thix->selectPlayer($sender);
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
    $form->addButton("§6Stadium Map \n §bPlayers[{$stadium}]");
$form->addButton("§6Mars Map \n §bPlayers[{$mars}]");
$form->addButton("§6boimic Map \n §b[{$biomic}]");$form->addButton("§6Market Map \n §bPlayers[{$Market}],0,textures/items/market");
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
$form->addButton("§6Gladiators Map");
$form->addButton("§6Kung Fu Arena Map");
$form->addButton("§6Ancient City Map");
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
    $properDuels = ProperDuels::getInstance();
$arenag1 = $properDuels->getArenaManager()->get('gladiator1');
if($arenag1 === null){
    $g1 = "Arena 'gladiator1' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator1')){
    $g1 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag1){
    $g1 = "1/2 Players. you can join";
}else{
    $g1 = "Arena empty";
}
$arenag2 = $properDuels->getArenaManager()->get('gladiator2');
if($arenag2 === null){
    $g2 = "Arena 'gladiator2' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator2')){
    $g2 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag2){
    $g2 = "1/2 Players. you can join";
}else{
    $g2 = "Arena empty";
}
$arenag3 = $properDuels->getArenaManager()->get('gladiator3');
if($arenag3 === null){
    $g3 = "Arena 'gladiator3' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator3')){
    $g3 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag3){
    $g3 = "1/2 Players. you can join";
}else{
    $g3 = "Arena empty";
}
$arenag4 = $properDuels->getArenaManager()->get('gladiator4');
if($arenag4 === null){
    $g4 = "Arena 'gladiator4' doesn't exists";
}elseif($properDuels->getGameManager()->has('gladiator4')){
    $g4 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenag4){
    $g4 = "1/2 Players. you can join";
}else{
    $g4 = "Arena empty";
}
                 $form->setTitle("§bDuels Map selector");
    $form->setContent("§3Pls select an empty map");
   $form->addButton("§6Gladiators 1 /n {$g1}");
    $form->addButton("§6Gladiators 2 /n {$g2}");
    $form->addButton("§6Gladiators 3 /n {$g3}");
    $form->addButton("§6Gladiators 4 /n {$g4}"); 
$player->sendForm($form);
}
public function kungfu1($player){
	$form = new SimpleForm(function (Player $player, int $data = null) {
		if($data === null){
			}
			switch($data){
				case 1:
				$this->getServer()->dispatchCommand($player, "duel queue kung1");
				break;
                                
                                case 2:
				$this->getServer()->dispatchCommand($player, "duel queue kung2");
				break;

                                case 3:
				$this->getServer()->dispatchCommand($player, "duel queue kung3");
				break;

                                case 4:
                                $this->getServer()->dispatchCommand($player, "duel queue kung4");
                                break;

                                case 5:
                                $this->getServer()->dispatchCommand($player, "duel queue kung5");
                                break;

                                case 6:
                                $this->getServer()->dispatchCommand($player, "duel queue kung6");
                                break;

                                case 7:
                                $this->getServer()->dispatchCommand($player, "duel queue kung7");
                                break;

                                case 8:
                                $this->getServer()->dispatchCommand($player, "duel queue kung8");
                                break;
           }
    });
    $properDuels = ProperDuels::getInstance();
$arenak1 = $properDuels->getArenaManager()->get('kung1');
if($arenak1 === null){
    $g1 = "Arena 'kung1' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung1')){
    $g1 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak1){
    $g1 = "1/2 Players. you can join";
}else{
    $g1 = "Arena empty";
}
$arenak2 = $properDuels->getArenaManager()->get('kung2');
if($arenak2 === null){
    $g2 = "Arena 'kung2' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung2')){
    $g2 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak2){
    $g2 = "1/2 Players. you can join";
}else{
    $g2 = "Arena empty";
}
$arenak3 = $properDuels->getArenaManager()->get('kung3');
if($arenak3 === null){
    $g3 = "Arena 'kung3' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung3')){
    $g3 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak3){
    $g3 = "1/2 Players. you can join";
}else{
    $g3 = "Arena empty";
}
$arenak4 = $properDuels->getArenaManager()->get('kung4');
if($arenak4 === null){
    $g4 = "Arena 'kung4' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung4')){
    $g4 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak4){
    $g4 = "1/2 Players. you can join";
}else{
    $g4 = "Arena empty";
}
$properDuels = ProperDuels::getInstance();
$arenak5 = $properDuels->getArenaManager()->get('kung5');
if($arenak5 === null){
    $g5 = "Arena 'kung5' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung5')){
    $g5 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak5){
    $g5 = "1/2 Players. you can join";
}else{
    $g5 = "Arena empty";
}
$arenak6 = $properDuels->getArenaManager()->get('kung6');
if($arenak6 === null){
    $g6 = "Arena 'kung6' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung6')){
    $g6 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak6){
    $g6 = "1/2 Players. you can join";
}else{
    $g6 = "Arena empty";
}
$arenak7 = $properDuels->getArenaManager()->get('kung7');
if($arenak7 === null){
    $g7 = "Arena 'kung7' doesn't exists";
}elseif($properDuels->getGameManager()->has('kung7')){
    $g7 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenak7){
    $g7 = "1/2 Players. you can join";
}else{
    $g7 = "Arena empty";
}
$form->setTitle("§bPls select a Empty Map");
$form->addButton("§6Kung Fu 1 \n {$g1}");
$form->addButton("§6Kung Fu 2 \n {$g2}");
$form->addButton("§6Kung Fu 3 \n {$g3}");
$form->addButton("§6Kung Fu 4 \n {$g4}");
$form->addButton("§6Kung Fu 5 \n {$g5}");
$form->addButton("§6Kung Fu 6 \n {$g6}");
$form->addButton("§6Kung Fu 7 \n {$g7}");
$player->sendForm($form);
}
public function city1($player){
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
    $properDuels = ProperDuels::getInstance();
$arenac1 = $properDuels->getArenaManager()->get('city1');
if($arenac1 === null){
    $g1 = "Arena 'city1' doesn't exists";
}elseif($properDuels->getGameManager()->has('city1')){
    $g1 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenac1){
    $g1 = "1/2 Players. you can join";
}else{
    $g1 = "Arena empty";
}
$arenac2 = $properDuels->getArenaManager()->get('city2');
if($arenac2 === null){
    $g2 = "Arena 'city2' doesn't exists";
}elseif($properDuels->getGameManager()->has('city2')){
    $g2 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenac2){
    $g2 = "1/2 Players. you can join";
}else{
    $g2 = "Arena empty";
}
$arenac3 = $properDuels->getArenaManager()->get('city3');
if($arenac3 === null){
    $g3 = "Arena 'city3' doesn't exists";
}elseif($properDuels->getGameManager()->has('city3')){
    $g3 = "Arena Full";
}elseif($properDuels->getQueueManager()->get($player->getUniqueId()->getBytes()) === $arenac3){
    $g3 = "1/2 Players. you can join";
}else{
    $g3 = "Arena empty";
}
                 $form->setTitle("§bPls select a Empty Map");
$form->addButton("§6City 1 \n {$g1}");
$form->addButton("§6City 2 \n {$g2}");
$form->addButton("§6City 3 \n {$g3}");
$player->sendForm($form);
}
}

