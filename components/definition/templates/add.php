<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
$text = TextCore::getInstance();
?>
<div class="card m-1 bg-light">
	<div class="card-header text-right text-success"><strong>Определение  <i class="fa fa-plus"></i></strong></div>
	<div class="card-body">
		<form action="" method="POST" name="add" id="add">
			<input type="hidden" name="action" value="add" />
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->title;?></strong></label>		
				<input class="form-control" type="text" id="title" name="title" />
			</div>
			<div class="form-group">
				<label class="control-label" for="type"><strong><?=$text->type;?></strong></label>	
				<select class="form-control" id="type" name="type">
					<?php if(!empty($types)) foreach($types as $type){?>
					<option value="<?=$type;?>"><?=$type;?></option>
					<?php } ?>
				</select>
			</div>			
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->description;?></strong></label>		
				<input class="form-control" type="text" id="description" name="description" />
			</div>	
		</form>	
	</div>
</div>
