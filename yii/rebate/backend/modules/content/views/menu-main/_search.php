<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\search\MenuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
      'data-pjax' => 1
    ],
  ]); ?>

  <?= $form->field($model, 'id') ?>

  <?= $form->field($model, 'title') ?>

  <?= $form->field($model, 'parent_id') ?>

  <?= $form->field($model, 'url') ?>

  <?= $form->field($model, 'status') ?>

  <?php // echo $form->field($model, 'order') ?>

  <div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
