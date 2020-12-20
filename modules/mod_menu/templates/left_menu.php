<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$user = UserCore::getInstance();
if($main->access) foreach($main->access as $item){
	$access[] = $item['id'];
} unset($item);
?>
<?php if($main->childs){ ?>
	<ul id="<?=$main->css_id;?>">
		<?php foreach($main->childs as $child) { ?>
			<?php 
			$link = new ObjectClasses($child->id);
 			$l_access = [];
			foreach($link->access as $item){
				$l_access[] = $item['id'];
			}			
			if(in_array($user->getUser()->id,$l_access) OR in_array('efec8802f9a4fe29f344',$l_access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5',$l_access))){ ?>
		<li>
			<a href="<?=$child->link;?>" target="<?=$child->target;?>" title="<?=$child->title;?>"><?=$child->title;?></a>
			<?=$child->render();?>	
		</li>
			<?php } ?>
		<?php } ?>
	</ul>
<?php } ?>