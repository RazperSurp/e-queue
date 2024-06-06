<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация в электронную очередь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="queue-register">
    <?php $form = ActiveForm::begin([
        'id' => 'queue-register-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4"> <?= $form->field($model, 'secondname') ?> </div>
                <div class="col-md-4"> <?= $form->field($model, 'firstname') ?> </div>
                <div class="col-md-4"> <?= $form->field($model, 'thirdname') ?> </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12"> 
                    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999 99-99']) ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary w-100']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
