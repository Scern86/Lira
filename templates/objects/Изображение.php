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
foreach($main->type as $type){
$types[] = $type['title'];	
}
?>
<?php if(in_array('Изображение',$types) AND (in_array($user->getUser()->id,$access) OR in_array('efec8802f9a4fe29f344',$access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5',$access)))){?>
	<?php if($main->params['mode']=='small'){?>
		<p><a href="<?=$hostname;?>/<?=$url;?>"><?=$main->title;?></a></p>
	<?php }else{ ?>
		<?php if($main->params['mode']=='medium'){?>
			<div class="float-left rounded m-1" style="width:150px;height:150px;" title="<?=$main->title;?>">
				<a class="fancybox" rel="fancybox" href="<?=$main->medium;?>" title="<?=$main->title;?>">
					<div class="text-truncate text-center imgs">
						<img class="d-block m-auto img-thumbnail" src="<?=$main->small;?>" border="0" style="width: 150px;" />
					</div>
				</a>	
			</div>
		<?php }else{?>
			<?php if($main->params['show_title']==1){?>
			<h1 class="text-center"><a href="<?=$hostname;?>/<?=$url;?>"><?=$main->title;?></a></h1>
			<?php } ?>		
			<img src="<?=$main->medium;?>" class="img-thumbnail" title="<?=$main->title;?>" />
		<?php } ?>
	<?php } ?>
	<style>
	.imgs { display: block; position: relative; }

	.imgs:after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url(/media/system/content/plus.png);background-size:150px;  opacity: 0; }

	.imgs:before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,.1); opacity: 1; }

	.imgs:hover:before,
	.imgs:hover:after { opacity: 1; }
	</style>
<?php } ?>	