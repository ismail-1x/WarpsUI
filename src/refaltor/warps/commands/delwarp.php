<?php

namespace refaltor\warps\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use refaltor\warps\api\WarpAPI;
use refaltor\warps\forms\CustomForm;
use refaltor\warps\forms\SimpleForm;

class delwarp extends Command
{
    public Plugin $plugin;

    public function __construct(Plugin $plugin, string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission('delete.warps.use');
        $this->setAliases(['dw']);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;
        if (!$this->testPermission($sender)) return;

        $api = new WarpAPI($this->plugin);
        $warps = $api->getAllWarps();
        $form = new SimpleForm(function (Player $player, $data = null) use ($warps, $api){
            if (is_null($data)) return;
            $id = $data;
            $name = $warps[$id];
            $api->removeWarp($name);
            $array = $this->plugin->getConfig()->get('message_delete_warp');
            if ($array['enable']) $player->sendMessage(str_replace('{warp}', $name, $array['content']));
        });
        foreach ($warps as $name){
            $form->addButton('§a' . $name);
        }
        $form->setTitle('§6- §eDelete warp §6-');
        $sender->sendForm($form);
    }
}