<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance(); 
?>
<div class="card m-1 border border-primary">	
	<div class="card-header bg-primary text-center text-light p-1">
		<strong>Тег</strong>		
	</div>
	<table class="table table-hover table-sm">
		<tbody>
		<?php
		if($list_tags) foreach($list_tags as $tag){ ?>
		<tr>
			<td width="100"><strong><?=strtoupper($tag['definition']);?></strong></td>
			<td><?=$tag['title'];?></td>
			<td width="40"><?=$tag['order'];?></td>
			<td width="80" class="text-right">
				<a class="btn btn-outline-warning btn-sm" href="/?com=object&task=edit_field&id=<?=$main->id;?>&field=<?=$tag['id'];?>&type=tag" title="Изменить"><i class="fas fa-pencil-alt"></i></a>
				<a class="btn btn-outline-danger btn-sm" href="/?com=object&task=remove_field&id=<?=$main->id;?>&field=<?=$tag['id'];?>&definition=<?=$tag['definition'];?>" title="Удалить"><i class="fas fa-trash-alt"></i></a>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>	
</div>