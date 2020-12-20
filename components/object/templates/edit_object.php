<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance();
$object_info = new ObjectClasses($object['id_object_child']);
$params = json_decode($object['params'],1);
?>
<form action="" method="POST" id="edit_field" name="edit_field" role="form">
	<input type="hidden" id="action" name="action" value="edit_field" />
	<input type="hidden" id="field" name="field" value="<?=$object['id_object_child'];?>" />	
	<div class="card m-1">
		<div class="card-header">
			<strong class="float-right text-warning">Объект: <?=$main->title;?> / Вложение: <?=$object_info->title;?> <i class="fa fa-pencil-alt"></i></strong>
		</div>			
		<div class="card-body">
			<div class="form-group">
				<label class="control-label" for="defintion"><strong>Определение</strong></label>
				<select class="form-control" id="definition" name="definition">
					<?php if(!empty($fields)) foreach($fields as $item){?>
						<?php if($item['title']==$object['definition']){?>
					<option value="<?=$item['title'];?>" selected><?=$item['title'].' ( '.$item['description'].' )';?></option>
						<?php }else{?>
					<option value="<?=$item['title'];?>"><?=$item['title'].' ( '.$item['description'].' )';?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="order"><strong>Порядок</strong></label>		
				<input class="form-control" type="number" id="order" name="order" value="<?=$object['order'];?>" />
			</div>				
		</div>
	</div>	
	<div class="card m-1">
		<div class="card-header text-center">
			<strong>Параметры</strong>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="control-label" for="params[type]"><strong>Шаблон отображения</strong></label>
				<select class="form-control" id="params[type]" name="params[type]">
					<?php if(!empty($type_list)) foreach($type_list as $type){?>
						<?php if($type==$params['type']){?>
					<option value="<?=$type;?>" selected><?=$type;?></option>
						<?php }else{?>
					<option value="<?=$type;?>"><?=$type;?></option>
						<?php } ?>
					<?php } unset($type); ?>
				</select>
			</div>		
			<div class="form-group">
				<label class="control-label" for="params[mode]"><strong>Режим отображения</strong></label>
				<select class="form-control" id="params[mode]" name="params[mode]">
					<?php if(!empty($mode_list)) foreach($mode_list as $k=>$m){?>
						<?php if($k==$params['mode']){?>
					<option value="<?=$k;?>" selected><?=$m;?></option>
						<?php }else{?>
					<option value="<?=$k;?>"><?=$m;?></option>
						<?php } ?>
					<?php } unset($k);unset($m); ?>
				</select>
			</div>	
			<div class="form-group">
				<label class="control-label" for="params[show_title]"><strong>Показывать заголовок</strong></label>
				<input type="hidden" name="params[show_title]" value="0" />
				<?php if($params['show_title']==1){?>
				<input type="checkbox" id="params[show_title]" name="params[show_title]" value="1" checked />
				<?php }else{ ?>
				<input type="checkbox" id="params[show_title]" name="params[show_title]" value="1" />
				<?php } ?>
			</div>			
		</div>
	</div>
</form>