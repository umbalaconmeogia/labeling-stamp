<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ConstantValue;

/* @var $this yii\web\View */
/* @var $model app\models\Stamp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stamp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::img($model->imageUrl) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'price_setting')->radioList(ConstantValue::getListOptions('STAMP_PRICE_SETTING')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
