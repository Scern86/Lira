<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
?>
<?php
	if(!empty($content)) foreach($content as $item){
		if(!empty($item)) foreach($item as $value){
			echo $value;
		}
	}
	unset($item);
	unset($value);				
?>