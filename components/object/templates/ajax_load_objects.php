<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
?>
<?php if (!empty($list)) foreach ($list as $item) { ?>
    <tr>
        <td width="30"><input class="m-1" type="checkbox" id="value[]" name="value[]" value="<?=$item['id'];?>" /></td>
        <td><strong><?=$item['title'];?></strong></td>
        <td><small><?=implode(',',array_shift($item['tags']));?></small></td>
    </tr>
<?php } ?>