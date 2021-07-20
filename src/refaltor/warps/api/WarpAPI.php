<?php

namespace refaltor\warps\api;

use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class WarpAPI
{
    public $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function createWarp(Position $position, string $name): void
    {
        $data = new Config($this->plugin->getDataFolder() . 'data/warps.json', Config::JSON);
        $position = $position->getX() . ':' . $position->getY() . ':' . $position->getZ() . ':' . $position->getLevel()->getFolderName();
        $data->set($name, $position);
        $data->save();
    }

    public function getAllWarps(): array
    {
        $data = new Config($this->plugin->getDataFolder() . 'data/warps.json', Config::JSON);
        $array = [];
        foreach ($data->getAll() as $name => $pos) $array[] = $name;
        return $array;
    }

    public function existWarp(string $name): bool
    {
        $data = new Config($this->plugin->getDataFolder() . 'data/warps.json', Config::JSON);
        return $data->exists($name);
    }

    public function removeWarp(string $name): void
    {
        $data = new Config($this->plugin->getDataFolder() . 'data/warps.json', Config::JSON);
        if ($data->exists($name)) {
            $data->remove($name);
            $data->save();
        }
    }

    public function tpToWarp(Player $player, string $name): void
    {
        $data = new Config($this->plugin->getDataFolder() . 'data/warps.json', Config::JSON);
        if ($data->exists($name))
        {
            $position = explode(':', $data->get($name));
            $level = $this->plugin->getServer()->getLevelByName($position[3]);
            $level->loadChunk($position[0] >> 4, $position[2] >> 4);
            $player->teleport(new Position($position[0], $position[1], $position[2], $level));
            $array = $this->plugin->getConfig()->get('messages_teleportation');
            if ($array['enable']) $player->sendMessage(str_replace('{warp}', $name, $array['content']));
        }
    }
}
