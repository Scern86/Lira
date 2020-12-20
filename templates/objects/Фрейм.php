<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$hostname = ConfigCore::getInstance()->hostname;
$alias = $main->alias;
if(!empty($alias)) $url = $alias;
else $url = '?com=object&task=show&id='.$main->id;
$user = UserCore::getInstance();
foreach($main->access as $item){
	$access[] = $item['id'];
}
?>
<?php if(in_array($user->getUser()->id,$access) OR in_array('efec8802f9a4fe29f344',$access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5',$access))){?>
	<?php if($main->params['mode']=='small'){?>
		<p><a href="<?=$hostname;?>/<?=$url;?>"><?=$main->title;?></a></p>
	<?php }else{ ?>
		<?php if($main->params['mode']=='medium'){?>
			<?php $thumbnail = array_shift($main->image)['id'];?>
			<?php $image = new ObjectClasses($thumbnail);?>
			<div class="float-left rounded m-1" style="width:150px;height:150px;" title="<?=$image->title;?>">
				<a href="<?=$hostname;?>/<?=$url;?>" title="<?=$main->title;?>">
					<div class="text-truncate text-center phs">
						<img class="d-block m-auto" src="<?=$image->small;?>" border="0" style="width: 150px;" />
					</div>
				</a>	
			</div>
		<?php }else{?>
			<br clear="all">
			<?php if($main->params['show_title']==1){?>
			<h1 class="text-center"><a href="<?=$hostname;?>/<?=$url;?>"><?=$main->title;?></a></h1>
			<?php } ?>		
			<div class="embed-responsive embed-responsive-16by9">
			  <iframe class="embed-responsive-item p-1" src="<?=$main->path;?>" allowfullscreen></iframe>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>	