<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance();
$field = RequestCore::getInstance()->type;
?>
<form action="" method="POST" id="add_field" name="add_field" role="form">
	<input type="hidden" id="action" name="action" value="add_field" />
	<div class="card m-1">
		<div class="card-header">
			<strong class="float-right text-success">Поле <i class="fa fa-plus"></i></strong></div>			
		<div class="card-body">
			<div class="form-group">
				<label class="control-label" for="defintion"><strong>Определение</strong></label>
				<select class="form-control" id="definition" name="definition">
					<?php if(!empty($fields)) foreach($fields as $item){?>
					<option value="<?=$item['title'];?>"><?=$item['title'].' ( '.$item['description'].' )';?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="value"><strong>Значение</strong></label>		
				<textarea class="form-control" type="text" id="value" name="value"></textarea>
				<script src="https://cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
				<script>CKEDITOR.replace( 'value' );</script>				
			</div>
		</div>
	</div>		
</form>