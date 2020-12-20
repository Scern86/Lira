<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$user = UserCore::getInstance();
foreach($main->access as $item){
	$access[] = $item['id'];
}
?>
<?php if(in_array($user->getUser()->id,$access) OR in_array('efec8802f9a4fe29f344',$access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5',$access))){?>
	<?php if($main->params['mode']=='small'){?>
		<p><a href="<?=$main->path;?>"><?=$main->title;?></a></p>
	<?php }else{ ?>
		<?php if($main->params['mode']=='medium'){?>
			<div class="clearfix m-1">
				<a itemprop="<?=$main->microdata;?>" href="<?=$main->path;?>" title="<?=$main->title;?>" target="_blank">
					<table class="table-borderless w-100 bg-light">
						<tr>
							<td width="52">
								<img src="/media/system/filetypes/<?=strtolower(pathinfo($main->path)['extension']);?>.png" width="50" />
							</td>
							<td class="align-middle">
								<h5 class="text-secondary"><?=$main->title;?></h5>
							</td>
							<td class="text-right" width="150">
								<strong class="text-success mr-2"><?=$main->filesize;?></strong>
							</td>					
						</tr>
					</table>
				</a>
			</div>
		<?php }else{?>
			<div class="clearfix m-1">
				<a itemprop="<?=$main->microdata;?>" href="<?=$main->path;?>" title="<?=$main->title;?>" target="_blank">
					<table class="table-borderless w-100 bg-light">
						<tr>
							<td width="52">
								<img src="/media/system/filetypes/<?=strtolower(pathinfo($main->path)['extension']);?>.png" width="50" />
							</td>
							<td class="align-middle">
								<h5 class="text-secondary"><?=$main->title;?></h5>
							</td>
							<td class="text-right" width="150">
								<strong class="text-success mr-2"><?=$main->filesize;?></strong>
							</td>					
						</tr>
					</table>
				</a>
			</div>		
		<?php } ?>
	<?php } ?>
<?php } ?>
