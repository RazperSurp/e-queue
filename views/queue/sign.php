<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Регистрация в электронную очередь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="queue-sign">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <img src="/web/img/queue-register.svg">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <a href="register?type=manual"> У меня нет с собой телефона </a>
        </div>
    </div>
</div>

<script type="text/javascript">
    let cookieObj = {};
    document.cookie.split('; ').forEach(pair => {
        let cookiePair = pair.split('=');
        obj[cookiePair[0]] = cookiePair[1];
    })

    if (cookieObj.eqpk) window.location.href = `${window.location.origin}/queue/position`;
</script>