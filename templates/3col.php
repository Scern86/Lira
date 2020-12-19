<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="x-ua-compatible" content="ie=edge">	
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title><?=$title;?></title>
		<meta name="description" content="<?=$description;?>">
		<meta name="keywords" content="<?=$keywords;?>">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		
		<!-- Соц.сети -->
		<meta property="og:locale" content="ru_RU"/>
		<meta property="og:type" content="article"/>
		<meta property="og:title" content="<?=$title;?>"/>
		<meta property="og:description" content="<?=$description;?>"/>
		<meta property="og:image" content="<?=$page_image;?>"/>
		<meta property="og:url" content="<?=$page_link;?>"/>
		<meta property="og:site_name" content="<?=$site_name;?>"/>		
				
	</head>
	<body style="background: url('/templates/bg2.png') fixed;">	
		<div class="container-fixed">	
			<div class="row no-gutters" style="background-color:#FFF;">
				<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-xl-10">
					<p  style="font-size:45pt;line-height:45pt;"><a href="/" title="<?=$site_name;?>" class="text-primary" style="text-decoration:none;color:"><?=$site_name;?></a></p>
				</div>
			</div>
			<div class="row no-gutters">
				<div class="col-xs-12 col-md-12 col-lg-12">				
					<?php
						if(!empty($top)) foreach($top as $item){
							if(!empty($item)) foreach($item as $value){
								echo $value;
							}
						}
						unset($item);
						unset($value);
					?>
				</div>
			</div>			
			<div class="row no-gutters">	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 order-lg-6 col-xl-8">
					<?php
						if(!empty($search)) foreach($search as $item){
							if(!empty($item)) foreach($item as $value){
								echo $value;
							}
						}
						unset($item);
						unset($value);				
					?>
					<div class="m-1 p-2 rounded-top" style="background-color: rgba(255, 255, 255, 0.9);">
					<?php
						if(!empty($content)) foreach($content as $item){
							if(!empty($item)) foreach($item as $value){
								echo $value;
							}
						}
						unset($item);
						unset($value);				
					?>
					</div>
				</div>				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 order-lg-1 col-xl-2">
					<?php
						if(!empty($left)) foreach($left as $item){
							if(!empty($item)) foreach($item as $value){
								echo $value;
							}
						}
						unset($item);
						unset($value);
					?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 order-lg-12 col-xl-2">
					<?php
						if(!empty($right)) foreach($right as $item){
							if(!empty($item)) foreach($item as $value){
								echo $value;
							}
						}
						unset($item);
						unset($value);
					?>
				</div>				
			</div>
			<div class="row no-gutters" style="height:100px;">
				<div class="col-xs-12">
					<?php
						if(!empty($bottom)) foreach($bottom as $item){
							if(!empty($item)) foreach($item as $value){
								echo $value;
							}
						}
						unset($item);
						unset($value);
					?>					
				</div>
			</div>
			<div class="footer bg-dark text-light">
				<div class="row no-gutters">
					<div class="col-md-3">						
						<?php
							if(!empty($footer1)) foreach($footer1 as $item){
								if(!empty($item)) foreach($item as $value){
									echo $value;
								}
							}
							unset($item);
							unset($value);
						?>
					</div>
					<div class="col-md-3 d-none d-lg-block">
						<?php
							if(!empty($footer2)) foreach($footer2 as $item){
								if(!empty($item)) foreach($item as $value){
									echo $value;
								}
							}
							unset($item);
							unset($value);
						?>
					</div>
					<div class="col-md-3 d-none d-lg-block">
						<?php
							if(!empty($footer3)) foreach($footer3 as $item){
								if(!empty($item)) foreach($item as $value){
									echo $value;
								}
							}
							unset($item);
							unset($value);
						?>				
					</div>					
					<div class="col-md-3 d-none d-lg-block">
						<?php
							if(!empty($footer4)) foreach($footer4 as $item){
								if(!empty($item)) foreach($item as $value){
									echo $value;
								}
							}
							unset($item);
							unset($value);
						?>
					</div>
				</div>
			</div>
		</div>
		<?=$message;?>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>				
	</body>	
</html>		