<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dishes */

$this->title = 'Create Dishes';
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelIng' => $modelIng,
        'model' => $model,
    ]) ?>

</div>
