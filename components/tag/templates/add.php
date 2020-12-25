<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance(); 
?>
<div class="card m-1">
	<div class="card-header text-right text-success"><strong><?=$text->tag?>  <i class="fa fa-plus"></i></strong></div>
	<div class="card-body bg-light">
		<form action="" method="POST" name="add" id="add">
			<input type="hidden" name="action" value="add" />
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->title?></strong></label>		
				<input class="form-control" type="text" id="title" name="title" />
			</div>
		</form>	
	</div>
</div>
