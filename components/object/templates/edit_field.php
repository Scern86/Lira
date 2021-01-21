<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
$field = \Scern\Lira\Core\Request::getInstance()->field;
$field_info = new \Scern\Lira\Classes\Definition($field);
?>
<form action="" method="POST" id="edit_field" name="edit_field" role="form">
    <input type="hidden" id="action" name="action" value="edit_field" />
    <div class="card m-1">
        <div class="card-header">
            <strong class="float-right text-warning"><?=$text->field?> <i class="fa fa-pencil-alt"></i></strong></div>
        <div class="card-body">
            <?php switch ($field_info->type) {
                case 'NUMBER'; ?>
                    <div class="form-group">
                        <label class="control-label" for="<?=$field;?>"><strong><?=$field_info->description;?></strong></label>
                        <input class="form-control" type="number" id="field[<?=$field;?>]" name="field[<?=$field;?>]" value="<?=$main->$field;?>" />
                    </div>
                <?php break;
                case 'STRING'; ?>
                    <div class="form-group">
                        <label class="control-label" for="<?=$field;?>"><strong><?=$field_info->description;?></strong></label>
                        <input class="form-control" type="text" id="field[<?=$field;?>]" name="field[<?=$field;?>]" value="<?=$main->$field;?>" />
                    </div>
                <?php break;
                case 'DATETIME'; ?>
                    <div class="form-group">
                        <label class="control-label" for="<?=$field;?>"><strong><?=$field_info->description;?></strong></label>
                        <input class="form-control" type="datetime" id="field[<?=$field;?>]" name="field[<?=$field;?>]" value="<?=$main->$field;?>" />
                    </div>
                <?php break;
                case 'TEXT'; ?>
                    <div class="form-group">
                        <label class="control-label" for="<?=$field;?>"><strong><?=$field_info->description;?></strong></label>
                        <textarea class="form-control" id="field[<?=$field;?>]" name="field[<?=$field;?>]"><?=$main->$field;?></textarea>
                    </div>
                <?php break;
                case 'LONGTEXT'; ?>
                    <div class="form-group">
                        <label class="control-label" for="<?=$field;?>"><strong><?=$field_info->description;?></strong></label>
                        <textarea class="form-control" id="field[<?=$field;?>]" name="field[<?=$field;?>]"><?=$main->$field;?></textarea>
                        <script src="https://cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
                        <script>CKEDITOR.replace( "field[<?=$field;?>]" );</script>
                    </div>
                <?php break;
            }?>
        </div>
    </div>
</form>