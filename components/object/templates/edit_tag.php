<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
$tag_info = new \Scern\Lira\Classes\Tag($tag['id_tag']);
?>
<form action="" method="POST" id="edit_field" name="edit_field" role="form">
    <input type="hidden" id="action" name="action" value="edit_field" />
    <input type="hidden" id="field" name="field" value="<?=$tag['id_tag'];?>" />
    <div class="card m-1">
        <div class="card-header">
            <strong class="float-right text-warning"><?=$text->object?>: <?=$main->title;?> / Тег: <?=$tag_info->title;?> <i class="fa fa-pencil-alt"></i></strong>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label" for="defintion"><strong><?=$text->definition?></strong></label>
                <select class="form-control" id="definition" name="definition">
                    <?php if (!empty($fields)) foreach ($fields as $item) {?>
                        <?php if ($item['title'] == $tag['definition']) {?>
                    <option value="<?=$item['title'];?>" selected><?=$item['title'].' ( '.$item['description'].' )';?></option>
                        <?php } else { ?>
                    <option value="<?=$item['title'];?>"><?=$item['title'].' ( '.$item['description'].' )';?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="order"><strong><?=$text->order?></strong></label>
                <input class="form-control" type="number" id="order" name="order" value="<?=$tag['order'];?>" />
            </div>
        </div>
    </div>
</form>