<?php
if (!empty($data)) extract ($data);
$session = \Scern\Lira\Core\Session::getInstance();
$user = \Scern\Lira\Core\User::getInstance()->getUser();
?>
<div class="card m-1 border-primary">
    <div class="card-header bg-light text-dark"><h5 class="text-center"><?=$user->title;?></h5></div>
    <div class="card-body">
        <nav class="nav nav-pills card-header-pills flex-column">
            <a class="btn btn-outline-primary float-right" href="/?auth=logout">Выход</a>
        </nav>
    </div>
</div>