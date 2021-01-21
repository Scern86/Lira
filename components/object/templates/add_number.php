<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
$field = \Scern\Lira\Core\Request::getInstance()->type;
?>
<form action="" method="POST" id="add_field" name="add_field" role="form">
    <input type="hidden" id="action" name="action" value="add_field" />
    <div class="card m-1">
        <div class="card-header">
            <strong class="float-right text-success"><?=$text->field?> <i class="fa fa-plus"></i></strong></div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label" for="defintion"><strong><?=$text->definition?></strong></label>
                <select class="form-control" id="definition" name="definition">
                    <?php if (!empty($fields)) foreach ($fields as $item) { ?>
                    <option value="<?=$item['title'];?>"><?=$item['title'].' ( '.$item['description'].' ) ';?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="value"><strong><?=$field;?></strong></label>
                <input class="form-control" type="number" id="value" name="value" />
            </div>
        </div>
    </div>
</form>