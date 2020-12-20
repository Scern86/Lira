<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance();
?>
<div class="card m-1 bg-light">
	<table class="table table-hover table-sm">
		<thead class="thead-light">
			<th><?=$text->title;?></th>
			<th width="100" class="text-right">Управление</th>
		</thead>
		<tbody id="result">
			<?php if(!empty($list)) foreach($list as $item){ ?>
			
			<tr>
				<td><?=$item['title'];?> | <small class="text-success"><?=date('d-m-Y',strtotime($item['created']));?></small> | <small class="text-primary"><?php if(!is_null($item['tags'][0])) echo implode(',',array_shift($item['tags']));?></small></td>
				<td class="text-right">
					<a class="btn btn-outline-warning btn-sm" href="/?com=object&task=edit&id=<?=$item['id'];?>"><i class="fas fa-pencil-alt"></i></a>				
					<a class="btn btn-outline-danger btn-sm" href="/?com=object&task=remove&id=<?=$item['id'];?>" onClick="return confirm('<?=$text->delete_confirmation;?>')"><i class="fas fa-trash-alt"></i></a>			
				</td>
			</tr>				
			<?php } ?>
		</tbody>
	</table>	
</div>

<script>
	$(document).ready(function(){
		var inProgress = false;
		var offset = 50;
		var limit = 50;

		$(window).scroll(function() {			
			if($(window).scrollTop() + $(window).height() >= $(document).height() - 300 && !inProgress) {				
				$.ajax({				
				  type: "POST",
				  url: '/?com=object&task=ajax&act=load',
				  data: {"offset" : offset,"limit":limit},
				  beforeSend: function() { inProgress = true;},
				  success: function(data) {
						$('#result').append(data);
						inProgress = false;
						offset += 50;
				  }
				})
			}			
		})		
	})
</script>
<script type="text/javascript">
$(function() {
	$("#search").keyup(function(){
		$.ajax({
			type: "POST",
			url: "/?com=object&task=ajax&act=search",
			data: {"search": $("#search").val()},
			cache: false,						
			success: function(response){
				$("#result").html(response);
			}
		});
		return false;				
	});
});
</script>