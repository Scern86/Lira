<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance();
?>
<form action="" method="POST" id="add" name="add" role="form">
	<input type="hidden" id="action" name="action" value="add" />
	<div class="card m-1">
		<div class="card-header text-right text-success"><strong><?=$text->object?> <i class="fa fa-plus"></i></strong></div>
		<div class="card-body">
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->title;?></strong></label>		
				<input class="form-control" type="text" id="title" name="title" />
			</div>
		</div>
	</div>	
</form>