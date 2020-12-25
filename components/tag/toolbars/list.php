<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
$text = TextCore::getInstance(); 
?>
<div class="card bg-dark m-1" id="toolbar">
	<div class="card-header">	
		<a href="/?com=tag&task=add" class="btn btn-success" title="<?=$text->add?>"><i class="fas fa-plus"></i></a>
	</div>
</div>
<script>
$(function() {
	var box = $('#toolbar'); // float-fixed block

	var top = box.offset().top - parseFloat(box.css('marginTop').replace(/auto/, 0));
	$(window).scroll(function(){
		var windowpos = $(window).scrollTop();
		if(windowpos < top) {
			box.css('position', 'static');
		} else {
			box.css('position', 'sticky');
			box.css('z-index', 1010);				
			box.css('top',0);
		}
	});
});
</script>