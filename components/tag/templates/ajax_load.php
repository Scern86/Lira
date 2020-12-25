<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
$text = TextCore::getInstance();
?>
<?php if(!empty($list)) foreach($list as $item){ ?>
<tr>
	<td><?=$item['title'];?></td>
	<td class="text-right">
		<a class="btn btn-outline-warning btn-sm" href="/?com=tag&task=edit&id=<?=$item['id'];?>" title="<?=$text->edit?>"><i class="fas fa-pencil-alt"></i></a>
		<a class="btn btn-outline-danger btn-sm" href="/?com=tag&task=delete&id=<?=$item['id'];?>" onClick="return confirm('<?=$text->delete_confirmation;?>')" title="<?=$text->remove?>"><i class="fas fa-trash-alt"></i></a>		
	</td>
</tr>	
<?php } ?>