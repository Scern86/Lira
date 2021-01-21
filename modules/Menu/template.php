<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract($data);
$params = json_decode($module->ext_params, 1);
$user = \Scern\Lira\Core\User::getInstance();
foreach ($module->access as $item) {
    $access[] = $item['id'];
}
?>
<?php if (in_array($user->getUser()->id, $access) OR in_array('efec8802f9a4fe29f344', $access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5', $access))){?>
    <?php if ($params['show_block'] == 1){ ?>
    <div class="card border-primary m-1">
        <?php if ($params['show_title'] == 1){ ?>
        <div class="card-header bg-primary">
            <h5 class="text-center text-light"><?=$module->title;?></h5>
        </div>
        <?php } ?>
        <div class="p-1">
            <?=$tree;?>
        </div>
    </div>
    <?php } else { ?>
        <?=$tree;?>
    <?php } ?>
<?php } ?>