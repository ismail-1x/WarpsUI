# WarpsUI
Plugins warpsUI

## Config

```YAML
---
# DO NOT TOUCH /!\
version: 1.0

messages_teleportation:
  enable: true
  content: "§6[§eWarps§6] You’ve just been beamed to warp §e{warp}"


message_create_warp:
  enable: true
  content: "§6[§eWarps§6] You just created the warp §e{warp}"


message_delete_warp:
  enable: true
  content: "§6[§eWarps§6] You just delete the warp §e{warp}"


message_create_warp_error_already_exist:
  enable: true
  content: "§6[§eWarps§6] §cthe warp §4{warp} §calready exists !"
...
```

## Permissions
create warps: ```warps.create.use```<br>
delete warps: ```warps.delete.use```

### Commands

```
/warp
/createwarp | /cw 
/deletewarp | /dw
```
