<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
$text = TextCore::getInstance();
?>
<?php if(!empty($list)) foreach($list as $item){ ?>

<tr>
	<td><?=$item['title'];?> | <small class="text-success"><?=date('d-m-Y',strtotime($item['created']));?></small> | <small class="text-primary"><?php if(!is_null($item['tags'][0])) echo implode(',',array_shift($item['tags']));?></small></td>	
	<td class="text-right">
		<a class="btn btn-outline-warning btn-sm" href="/?com=object&task=edit&id=<?=$item['id'];?>"><i class="fas fa-pencil-alt"></i></a>	
		<a class="btn btn-outline-danger btn-sm" href="/?com=object&task=remove&id=<?=$item['id'];?>" onClick="return confirm('<?=$text->delete_confirmation;?>')"><i class="fas fa-trash-alt"></i></a>			
	</td>
</tr>				
<?php } ?>