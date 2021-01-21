<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
?>
<div class="card m-1" id="toolbar">
    <div class="card-header bg-dark">
        <a href="/?com=object&task=list" class="btn btn-secondary" title="Назад"><i class="fas fa-arrow-left"></i></a>
        &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
        <a href="#" class="btn btn-success" onclick="document.edit.action='/?com=object&task=edit&id=<?=$id;?>'; document.edit.submit(); return false;" title="Сохранить и закрыть"><i class="fas fa-save"></i> <i class="fas fa-times"></i></a>
        <a href="#" class="btn btn-warning" onclick="document.edit.action='/?com=object&task=edit&id=<?=$id;?>&type=save'; document.edit.submit(); return false;" title="Сохранить"><i class="fas fa-save"></i></a>
        <a href="#" class="btn btn-info" onclick="document.edit.action='/?com=object&task=edit&id=<?=$id;?>&type=new'; document.edit.submit(); return false;" title="Сохранить и создать"><i class="fas fa-save"></i> <i class="fas fa-plus"></i></a>
        &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" title="Добавить поле объекта"><i class="fas fa-cubes"></i></button>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Поля объекта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <p><span class="fa fa-dice-five"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=number">Число</a></p>
                            <p><span class="fa fa-text-width"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=string">Строка</a></p>
                            <p><span class="fa fa-calendar-alt"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=datetime">Дата</a></p>
                            <p><span class="fa fa-file-alt"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=text">Короткий блок текста</a></p>
                            <p><span class="fa fa-file-alt"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=longtext">Большой блок текста</a></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p><span class="fa fa-tags"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=tag">Тег</a></p>
                            <p><span class="fa fa-paperclip"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=object">Имеющийся объект</a></p>
                            <p><span class="fa fa-download"></span> <a href="/?com=object&task=add_field&id=<?=$id;?>&type=upload">Загрузить объект/ы</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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