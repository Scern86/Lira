<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance();
?>
<form action="" method="POST" id="edit" name="edit" role="form">
	<input type="hidden" id="action" name="action" value="edit" />
	<div class="card m-1">
		<div class="card-header">
			<span class="float-left text-dark">ID: <?=$main->id;?> &nbsp;/&nbsp;CREATED: <?=$main->created;?></span>
			<strong class="float-right text-warning"><?=$text->object?> <i class="fa fa-pencil-alt"></i></strong></div>			
		<div class="card-body">
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->title;?></strong></label>		
				<input class="form-control" type="text" id="title" name="title" value="<?=$main->title;?>" />
			</div>
		</div>
	</div>		
</form>
<p class="text-right"><a class="btn btn-success" href="/?com=object&task=select_field&id=<?=$main->id;?>" title="Добавить"><i class="fa fa-plus"></i> <?=$text->add_field?></a></p>
<div class="row no-gutters">
	<div class="col-md-6">
		<?=$fields;?>
	</div>
	<div class="col-md-6">
		<?=$tags;?>
	</div>	
</div>
<?=$objects;?>