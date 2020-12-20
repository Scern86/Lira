<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
$text = TextCore::getInstance(); 
?>
<div class="card m-1">
	<div class="card-header text-right text-warning"><strong>Тег  <i class="fa fa-pencil-alt"></i></strong></div>
	<div class="card-body bg-light">
		<form action="" method="POST" name="edit" id="edit">
			<input type="hidden" name="action" value="edit" />			
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->title?></strong></label>		
				<input class="form-control" type="text" id="title" name="title" value="<?=$main->title;?>" />
			</div>
		</form>		
	</div>	
</div>
