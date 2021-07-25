<?php

namespace refaltor\warps\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use refaltor\warps\api\WarpAPI;
use refaltor\warps\forms\CustomForm;

class createwarp extends Command
{
    public $plugin;

    public function __construct(Plugin $plugin, string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission('warps.create.use');
        $this->setAliases(['cw']);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;
        if (!$this->testPermission($sender)) return;

        $form = new CustomForm(function (Player $player, $data = null){
            if (is_null($data)) return;
            $name = $data[0];
            $api = new WarpAPI($this->plugin);
            if (!$api->existWarp($name)){
                $api->createWarp($player, $name);
                $array = $this->plugin->getConfig()->get('message_create_warp');
                if ($array['enable']) $player->sendMessage(str_replace('{warp}', $name, $array['content']));
            }else {
                $array = $this->plugin->getConfig()->get('message_create_warp_error_already_exist');
                if ($array['enable']) $player->sendMessage(str_replace('{warp}', $name, $array['content']));
            }
        });
        $form->setTitle("§6- §eCreate warp §6-");
        $form->addInput("name", 'box');
        $sender->sendForm($form);
    }
}
