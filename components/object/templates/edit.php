<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
?>
<form action="" method="POST" id="edit" name="edit" role="form">
    <input type="hidden" id="action" name="action" value="edit" />
    <div class="card m-1">
        <div class="card-header">
            <span class="float-left text-dark"><?=$main->id;?></span>
            <strong class="float-right text-warning"><?=$text->object?> <i class="fa fa-pencil-alt"></i></strong></div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label" for="created"><strong><?=$text->created;?></strong></label>
                <input class="form-control" type="datetime" id="created" name="created" value="<?=$main->created;?>" />
            </div>
            <div class="form-group">
                <label class="control-label" for="title"><strong><?=$text->title;?></strong></label>
                <input class="form-control" type="text" id="title" name="title" value="<?=$main->title;?>" />
            </div>
        </div>
    </div>
</form>
<div class="row no-gutters">
    <div class="col-md-6">
        <?=$fields;?>
    </div>
    <div class="col-md-6">
        <?=$tags;?>
    </div>
</div>
<?=$objects;?>