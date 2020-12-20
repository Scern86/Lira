<?php if(!empty($data)) extract($data);?>
<div class="form-group">
	<label class="control-label" for="status">
	<?php if($main->params['show_title']<>1){?>
	<input class="form-controls " type="checkbox" id="params[show_title]" name="params[show_title]" value="1" />						
	<?php }else{ ?>
	<input class="form-controls" type="checkbox" id="params[show_title]" name="params[show_title]" checked value="1" />						
	<?php }?>
	<strong>Показывать название меню</strong></label>
</div>
<div class="form-group">
	<label class="control-label" for="status">
	<?php if($main->params['show_block']<>1){?>
	<input class="form-controls " type="checkbox" id="params[show_block]" name="params[show_block]" value="1" />						
	<?php }else{ ?>
	<input class="form-controls" type="checkbox" id="params[show_block]" name="params[show_block]" checked value="1" />						
	<?php }?>
	<strong>Оборачивать в блок</strong></label>
</div>
<div class="form-group">
	<label class="control-label" for="id_menu"><strong>ID меню</strong></label>		
	<input class="form-control" type="text" id="params[id_menu]" name="params[id_menu]" value="<?=$main->params['id_menu'];?>" />
</div>	
<div class="form-group">
	<label class="control-label" for="template"><strong>Шаблон</strong></label>		
	<input class="form-control" type="text" id="params[template]" name="params[template]" value="<?=$main->params['template'];?>" />
</div>
<div class="form-group">
	<label class="control-label" for="css_id"><strong>CSS ID</strong></label>		
	<input class="form-control" type="text" id="params[css_id]" name="params[css_id]" value="<?=$main->params['css_id'];?>" />
</div>