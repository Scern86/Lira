<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$user = UserCore::getInstance()->getUser();
?>
<?php if($main->level>0){ ?>
	<?php if($main->childs){ ?>
		<ul>
			<?php foreach($main->childs as $child) { ?>
				<?php if(in_array($user->id,$child->access) OR in_array('7e924debb58da91f39be',$child->access) OR ($user->status==1 AND in_array('7c30e1a868390c9098a3',$child->access))){ ?>
				<li>
					<a href="<?=$child->link;?>" target="<?=$child->target;?>" title="<?=$child->title;?>"><?=$child->title;?></a>
					<?=$child->render();?>	
				</li>
				<?php } ?>
			<?php } ?>
		</ul>
	<?php } ?>
<?php }else{ ?>
	<?php if($main->childs){ ?>
		<nav id="<?=$main->css_id;?>">
			<ul>
				<?php foreach($main->childs as $child) { ?>
					<?php if(in_array($user->id,$child->access) OR in_array('7e924debb58da91f39be',$child->access) OR ($user->status==1 AND in_array('7c30e1a868390c9098a3',$child->access))){ ?>
					<li>
						<a href="<?=$child->link;?>" target="<?=$child->target;?>" title="<?=$child->title;?>"><?=$child->title;?></a>
						<?=$child->render();?>	
					</li>
					<?php } ?>
				<?php } ?>
			</ul>
		</nav>	
	<?php } ?>
<?php } ?>
