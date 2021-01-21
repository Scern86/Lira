<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
?>
<form enctype="multipart/form-data" action="" method="POST" name="upload" id="upload">
    <input type="hidden" name="action" value="upload" />
    <input type="hidden" name="resize_images" value="0" />
    <div class="card-group m-1">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <input type="file" name="upload[]" <?php if($multiple) echo 'multiple="multiple"';?> />
                </div>
                <br/>
                <br/>
                <br/>
                <div class="form-group">
                    <button class=" btn btn-outline-success" type="submit">Загрузить</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="resize_images" value="1" checked />
                        Обрабатывать изображения (resize,thumbnail)
                    </label>
                </div>
                <p><strong>Превью</strong></p>
                <div class="form-row">
                    <div class="col">
                        <input class="form-control" type="number" name="w" value="200" />
                    </div>
                    x
                    <div class="col">
                        <input class="form-control" type="number" name="h" value="200" />
                    </div>
                </div>
                <br/>
                <p><strong>Основное изображение</strong></p>
                <div class="form-row">
                    <div class="col">
                        <input class="form-control" type="number" name="m" value="1280" />
                    </div>
                    x
                    <div class="col">
                        <input class="form-control" type="text" value="auto" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
