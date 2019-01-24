<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dishes */

$this->title = 'Update Dishes: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dishes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'modelIng' => $modelIng,
        'model' => $model,
    ]) ?>

</div>
