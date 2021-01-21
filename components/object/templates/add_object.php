<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
$field = \Scern\Lira\Core\Request::getInstance()->type;
?>
<form action="" method="POST" id="add_field" name="add_field" role="form">
    <input type="hidden" id="action" name="action" value="add_field" />
    <div class="card m-1">
        <div class="card-header">
            <strong class="float-right text-success"><?=$text->object?> <i class="fa fa-plus"></i></strong></div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label" for="defintion"><strong><?=$text->definition?></strong></label>
                <select class="form-control" id="definition" name="definition">
                    <?php if (!empty($fields)) foreach ($fields as $item) { ?>
                    <option value="<?=$item['title'];?>"><?=$item['title'].' ( '.$item['description'].' )';?></option>
                    <?php } ?>
                </select>
            </div>
            <table class="table table-bordered">
                <tbody id="result">
                <?php if (!empty($objects)) foreach ($objects as $item) { ?>
                    <tr>
                        <td width="30"><input class="m-1" type="checkbox" id="value[]" name="value[]" value="<?=$item['id'];?>" /></td>
                        <td><strong><?=$item['title'];?></strong></td>
                        <td><small><?=implode(',',array_shift($item['tags']));?></small></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</form>
<script>
    $(document).ready(function($){
        var inProgress = false;
        var offset = 50;
        var limit = 50;

        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 1200 && !inProgress) {

                $.ajax({
                  type: "POST",
                  url: '/?com=object&task=ajax&act=load_objects',
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
            url: "/?com=object&task=ajax&act=search_objects",
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