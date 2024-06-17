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
        let cookieObj = {};
        document.cookie.split('; ').forEach(pair => {
            let cookiePair = pair.split('=');
            cookieObj[cookiePair[0]] = cookiePair[1];
        })

        <?php if (isset($id) && isset($time)): ?>
            if (typeof cookieObj.eqpk == 'undefined' || cookieObj.eqpk == null) {
                document.cookie = `eqpk=<?= $id ?>_<?= $time ?>; path=/; expires=${(new Date(Date.now() + 86400e3)).toUTCString()}; samesite;`
                cookieObj.eqpk = '<?= $id ?>_<?= $time ?>';
            }
        <?php else: ?>
            if (typeof cookieObj.eqpk == 'undefined' || cookieObj.eqpk == null) {
                window.location.href = `${window.location.origin}/queue/register`;
            }
        <?php endif; ?>

        if (cookieObj.eqpk) {
            setInterval(() => {
                fetch(`${window.location.origin}/queue/check?token=${cookieObj.eqpk}`).then(response => {
                    if (response.status == 401) {
                        document.cookie = '';
                        window.location.href = `${window.location.origin}/queue/register`;
                    } else if (response.status == 200) {
                        response.json().then()
                    }
                })
            }, 1000);
        }
    })
</script>