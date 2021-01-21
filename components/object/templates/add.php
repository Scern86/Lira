<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = \Scern\Lira\Core\Text::getInstance();
?>
<form action="" method="POST" id="add" name="add" role="form">
    <input type="hidden" id="action" name="action" value="add" />
    <div class="card m-1">
        <div class="card-header text-right text-success"><strong><?=$text->object?> <i class="fa fa-plus"></i></strong></div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label" for="created"><strong><?=$text->created;?></strong></label>
                <input class="form-control" type="datetime" id="created" name="created" value="<?=date('Y-m-d H:i:s');?>" />
            </div>
            <div class="form-group">
                <label class="control-label" for="title"><strong><?=$text->title;?></strong></label>
                <input class="form-control" type="text" id="title" name="title" />
            </div>
        </div>
    </div>
</form>