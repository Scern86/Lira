<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data);
$text = TextCore::getInstance();
?>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=number">Число</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=string">Строка</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=datetime">Дата</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=text">Короткий текст</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=longtext">Большой текст</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=tag">Тег</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=object">Объект</a></p>
<p><a href="/?com=object&task=add_field&id=<?=$id;?>&type=upload">Загрузить объект/ы</a></p>