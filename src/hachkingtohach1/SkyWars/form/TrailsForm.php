<?php

/**
 *  Copyright (c) 2022 hachkingtohach1
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *  SOFTWARE.
 */
 
namespace hachkingtohach1\SkyWars\form;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use hachkingtohach1\SkyWars\SkyWars;
use hachkingtohach1\SkyWars\cosmetics\Cosmetics;

class TrailsForm{

    /**
     * @param Player $player
     * @return mixed
     */
    public static function getForm(Player $player){
		$api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createSimpleForm(function (Player $player, int $data = null){
		    $result = $data;
		    if($result === null){
			    return true;
			}
			//convert index to id trail
			$check = [33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49];
		    if(isset(Cosmetics::TRAILS[$check[$result]])){
				if(!$player->hasPermission("skywars.trials")){
				    $player->sendMessage(TextFormat::RED."§l§4»§r§c You have not unlocked this trail yet!");
					return false;
				}			
				SkyWars::getInstance()->getCosmetics()->setTrail($player, $check[$result]);
			    $player->sendMessage(TextFormat::GREEN."§l§2»§r§a Successfully activated trail!");
				return true;
			}
			return false;
		});
		$form->setTitle(TextFormat::BOLD.TextFormat::GREEN."Trails");
		foreach(Cosmetics::TRAILS as $case => $trail){
		    if(SkyWars::getInstance()->getCosmetics()->checkTrailPlayer($player, $case)){
			    $form->addButton(TextFormat::GREEN.$trail, 0, "");
			}else{
				if($player->hasPermission("skywars.trails")){
				    $form->addButton(TextFormat::GOLD.$trail, 0, "");
				}else{
					$form->addButton(TextFormat::RED.$trail, 0, "");
				}
			}
		}
		$form->sendToPlayer($player);
		return $form;
	}
}
