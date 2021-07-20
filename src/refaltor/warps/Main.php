<?php

namespace refaltor\warps;

use pocketmine\plugin\PluginBase;
use refaltor\warps\api\WarpAPI;
use refaltor\warps\commands\createwarp;
use refaltor\warps\commands\delwarp;
use refaltor\warps\commands\warp;

class Main extends PluginBase
{
    public $api;

    public function onEnable(): void
    {
        $this->api = new WarpAPI($this);
        $this->saveResource('config.yml');
        @mkdir($this->getDataFolder() . 'data/');
        $this->getServer()->getCommandMap()->register('createWarp', new createwarp($this, 'createwarp','Allows you to create warps'));
        $this->getServer()->getCommandMap()->register('delwarp', new delwarp($this, 'delwarp','Allows you to remove warps'));
        $this->getServer()->getCommandMap()->register('warp', new warp($this, 'warp','Allows you to get to a warp'));
    }

}
