<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\dishes */
/* @var $form yii\widgets\ActiveForm */
$arrayDish = \yii\helpers\ArrayHelper::map($modelIng, 'id', 'title');
?>

<div class="dishes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList([
        '1' => 'Активный',
        '0' => 'Не активный'
    ]) ?>
    <?= $form->field($model, 'arrayIng')->dropDownList($arrayDish, ['multiple' => 'true'])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
