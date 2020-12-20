<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
$text = TextCore::getInstance();
?>
<?php if(!empty($list)) foreach($list as $item){ ?>
<tr>
	<td><?=$item['title'];?> | <small class="text-success"><?=$item['type'];?></small> | <small class="text-info"><?=$item['description'];?></small></td>
	<td class="text-right">
		<a class="btn btn-outline-warning btn-sm" href="/?com=definition&task=edit&title=<?=$item['title'];?>"><i class="fas fa-pencil-alt"></i></a>
		<a class="btn btn-outline-danger btn-sm" href="/?com=definition&task=remove&title=<?=$item['title'];?>" onClick="return confirm('<?=$text->delete_confirmation;?>')"><i class="fas fa-trash-alt"></i></a>		
	</td>
</tr>	
<?php } ?>