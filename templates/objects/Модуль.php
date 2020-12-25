<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$user = UserCore::getInstance();
foreach($main->access as $item){
	$access[] = $item['id'];
}
$module_name = 'ControllerModules'.ucfirst($main->module);
$module = new $module_name($main->id);
?>
<?php if(in_array($user->getUser()->id,$access) OR in_array(ObjectClasses::getIdByTitle('Все'),$access) OR ($user->isLoggedIn() AND in_array(ObjectClasses::getIdByTitle('Зарегистрированные'),$access))){?>
<?=$module->action();?>
<?php } ?>