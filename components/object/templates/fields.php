<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance(); 
?>
<div class="card m-1 border border-success">	
	<div class="card-header bg-success text-center text-light p-1">
		<strong><?=$text->field_type?></strong>		
	</div>
	<table class="table table-hover table-sm">
		<tbody>
		<?php
		if($list_fields) foreach($list_fields as $field){ ?>
		<tr>
			<td width="100"><strong><?=strtoupper($field['definition']);?></strong></td>
			<td><?=trim(strip_tags(mb_substr($field['field'],0,20)));?></td>
			<td width="80" class="text-right">
				<a class="btn btn-outline-warning btn-sm" href="/?com=object&task=edit_field&id=<?=$main->id;?>&field=<?=$field['definition'];?>&type=field" title="Изменить"><i class="fas fa-pencil-alt"></i></a>
				<a class="btn btn-outline-danger btn-sm" href="/?com=object&task=remove_field&id=<?=$main->id;?>&definition=<?=$field['definition'];?>" title="Удалить"><i class="fas fa-trash-alt"></i></a>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>	
</div>