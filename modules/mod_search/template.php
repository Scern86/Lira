<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
?>
<form action="#" method="POST" role="form" class="m-1">
	<div class="row no-gutters">
		<div class="col-sm-11 p-1">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text border-primary text-dark">
						<i class="fa fa-search"></i>
					</div>
				</div>			
				<input class="form-control border-primary text-dark" type="text" id="search" name="search" autocomplete="off" placeholder="Поиск" onkeydown="return event.key != 'Enter';" />
			</div>	
		</div>
		<div class="col-sm-1 p-1">
			<input class="btn btn-light border-primary text-primary" type="submit" value="Поиск" />
		</div>
	</div>
</form>