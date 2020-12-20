<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance(); 
?>
<div class="card m-1 border border-warning">	
	<div class="card-header bg-warning text-center text-light p-1">
		<strong>Объект</strong>		
	</div>
	<table class="table table-hover table-sm">
		<tbody>
		<?php
		if($list_objects) foreach($list_objects as $obj){ ?>
		<tr>
			<td width="100"><strong><?=strtoupper($obj['definition']);?></strong></td>
			<td><?=$obj['title'];?></td>
			<td width="50"><?=$obj['order'];?></td>
			<td width="80" class="text-right">
				<a class="btn btn-outline-warning btn-sm" href="/?com=object&task=edit_field&id=<?=$main->id;?>&field=<?=$obj['id'];?>&definition=<?=$obj['definition'];?>&type=object" title="Изменить"><i class="fas fa-pencil-alt"></i></a>
				<a class="btn btn-outline-danger btn-sm" href="/?com=object&task=remove_field&id=<?=$main->id;?>&field=<?=$obj['id'];?>&definition=<?=$obj['definition'];?>" title="Удалить"><i class="fas fa-trash-alt"></i></a>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>	
</div>