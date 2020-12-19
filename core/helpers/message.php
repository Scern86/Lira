<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
?>
<?php if(!empty($message)){ ?>
<link rel="stylesheet" href="/templates/js/jGrowl/jquery.jgrowl.css" type="text/css"/>
<script type="text/javascript" src="/templates/js/jGrowl/jquery.jgrowl.min.js"></script>
<script type="text/javascript" src="/templates/js/jGrowl/jquery.jgrowl.min.js"></script>	
<script type="text/javascript">	
	var $ = jQuery;
	jQuery(document).ready(function($) {
		$.noConflict();
		$('#Notify').jGrowl({
			header: '<?=$header;?>',
			message: '<p class="text-center"><strong><?=$message;?></strong></strong>',
			group: '<?=$group;?>',
			life: 5000
		});			
	});
</script>
<div id="Notify" class="jGrowl bottom-right"></div>	
<?php } ?>