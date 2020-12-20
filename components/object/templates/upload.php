<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
?>
<div class="card m-1">
	<div class="card-body bg-light">
		<form enctype="multipart/form-data" action="" method="POST" name="upload" id="upload">
			<input type="hidden" name="action" value="upload" />
			
			<div class="form-group">	
				<input class="form-controls" type="file" name="upload[]" multiple="multiple" />
			</div>
			<div class="form-group">
				<label>Ширина preview</label>
				<input class="form-controls" type="text" name="w" value="200" />
			</div>
			<div class="form-group">
				<label>Высота preview</label>			
				<input class="form-controls" type="text" name="h" value="200" />
			</div>
			<div class="form-group">
				<label>Ширина medium</label>			
				<input class="form-controls" type="text" name="m" value="1280" />
			</div>				
		</form>	
	</div>
</div>
