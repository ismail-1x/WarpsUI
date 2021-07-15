<?php

namespace refaltor\warps\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use refaltor\warps\api\WarpAPI;
use refaltor\warps\forms\CustomForm;
use refaltor\warps\forms\SimpleForm;

class warp extends Command
{
    public Plugin $plugin;

    public function __construct(Plugin $plugin, string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setAliases(['w']);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;
        $form = new SimpleForm(function (Player $player, $data = null){
            if (is_null($data)) return;
            $api = new WarpAPI($this->plugin);
            $name = $api->getAllWarps()[$data];
            if ($api->existWarp($name)) {
                $api->tpToWarp($player, $name);
            }
        });
        $form->setTitle("§6- §eWarps §6-");
        $api = new WarpAPI($this->plugin);
        foreach ($api->getAllWarps() as $name){
            $form->addButton('§a' . $name);
        }
        $sender->sendForm($form);
    }
}