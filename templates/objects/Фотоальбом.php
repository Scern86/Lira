<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$hostname = ConfigCore::getInstance()->hostname;
$alias = $main->alias;
if(!empty($alias)) $url = $hostname.'/'.$alias.'?template=Фотоальбом';
else $url = $hostname.'/'.'?com=object&task=show&id='.$main->id.'&template=Фотоальбом';
$user = UserCore::getInstance();
foreach($main->access as $item){
	$access[] = $item['id'];
}
$count = 0;
?>
<?php if(in_array($user->getUser()->id,$access) OR in_array('efec8802f9a4fe29f344',$access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5',$access))){?>
	<?php if($main->params['mode']=='small'){?>
		<p><a href="<?=$hostname;?>/<?=$url;?>"><?=$main->title;?></a></p>
	<?php }else{ ?>
		<?php if($main->params['mode']=='medium'){?>
			<?php $thumbnail = array_pop($main->attachment)['id'];?>
			<?php $image = new ObjectClasses($thumbnail);?>
			
			<div class="float-left rounded m-1" style="width:150px;height:150px;" title="<?=$main->title;?>">
				<a href="<?=$url;?>" title="<?=$main->title;?>">
					<div class="text-truncate text-center imgss" style="position:relative;">
						<img src="/media/system/filetypes/group.png" width="60" height="60" style="position:absolute;right:-7px;bottom:35px;" />
						<img class="d-block m-auto img-thumbnail" src="<?=$image->small;?>" border="0" style="width: 150px;" />					
					</div>
				</a>	
			</div>
		<?php }else{?>
			<br clear="all">
			<?php if($main->params['show_title']==1){?>
			<h1 class="text-center"><a href="<?=$hostname;?>/<?=$url;?>"><?=$main->title;?></a></h1>
			<?php } ?>
			<p class="text-secondary"><i class="fa fa-image"></i> <?=count($main->attachment);?></p>
			<div id="result">
			<?php if($main->attachment) foreach($main->attachment as $key=>$item){ ?>
				
				<?php if($count<50){?>
				<?php $image = new ObjectClasses($item['id']);?>
				<?=$image->render('default',['mode'=>'medium']);?>
				<?php $count++;?>
				<?php } ?>
				
			<?php } unset($image); ?>
			</div>
			<div class="clearfix"></div>
		<?php } ?>
	<?php } ?>
<?php } ?>
<script>
	$(document).ready(function($){
		var inProgress = false;
		var offset = 50;
		var limit = 50;
		
		$(window).scroll(function() {			
			if($(window).scrollTop() + $(window).height() >= $(document).height() - 1200 && !inProgress) {
				var url = '/?com=object&task=ajax&act=load_attachments&id=<?=$main->id?>&o=' + offset + '&type=Фотоальбом';				
				$.ajax({				
				  type: "POST",			  
				  url: url,
				  data: {"offset" : offset,"limit":limit},
				  beforeSend: function() { inProgress = true;},
				  success: function(data) {
						$('#result').append(data);
						inProgress = false;
						offset += 50;
						$('a.fancybox').fancybox({type:'image'});	
				  }
				})
			}			
		})		
	})
</script>