<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Позиция в электронной очереди';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="queue-position">
    <div class="text-center">
        <h1> Ваш регистрационный номер: </h1>
    </div>
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 style="font-size: 100px"> <?= $id ?> </h1>
    </div>
    <div class="text-center">
        <h1> Вы зарегистрировались в <?= date('H:i:s', $time) ?> </h1>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        if ()

        if (!window.localStorage.getItem('queue')) {
            window.localStorage.setItem('queue', { id: <?= $id ?>, time: <?= $time ?> });
        }
    })
</script>