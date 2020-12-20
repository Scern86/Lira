<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
?>
<?php if(!empty($list)) foreach($list as $item){ ?>
	<tr>
		<td width="30"><input class="m-1" type="checkbox" id="value[]" name="value[]" value="<?=$item['id'];?>" /></td>
		<td><strong><?=$item['title'];?></strong></td>
	</tr>			
<?php } ?>