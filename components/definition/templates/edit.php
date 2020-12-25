<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance(); 
?>
<div class="card m-1 bg-light">
	<div class="card-header text-right text-warning"><strong><?=$text->definition;?>  <i class="fa fa-pencil-alt"></i></strong></div>
	<div class="card-body">
		<form action="" method="POST" name="edit" id="edit">
			<input type="hidden" name="action" value="edit" />
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->title;?></strong></label>		
				<input class="form-control" type="text" id="title" name="title" value="<?=$main->title;?>" />
			</div>
			<div class="form-group">
				<label class="control-label" for="type"><strong><?=$text->type;?></strong></label>	
				<select class="form-control" id="type" name="type">
					<?php if(!empty($types)) foreach($types as $type){?>
						<?php if($main->type==$type){?>
					<option value="<?=$type;?>" selected><?=$type;?></option>
						<?php } else { ?>
					<option value="<?=$type;?>"><?=$type;?></option>	
						<?php } ?>
					<?php } ?>
				</select>
			</div>		
			<div class="form-group">
				<label class="control-label" for="title"><strong><?=$text->description;?></strong></label>		
				<input class="form-control" type="text" id="description" name="description" value="<?=$main->description;?>" />
			</div>	
		</form>	
	</div>
</div>