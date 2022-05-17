<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var array $parents common\models\Menu */
/* @var common\models\Menu $menu_type type_id */

$this->title = Yii::t('backend', 'Update');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = !$model->type_id ? ['label' => 'Меню', 'url' => ['index']] : ['label' => 'Меню', 'url' => ['index', 'menu' => $model->type_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="menu-update">

  <!-- <h1><?php //echo Html::encode($this->title) ?></h1> -->

  <?= $this->render('_form', [
    'model' => $model,
    'parents' => $parents,
    'languages' => $languages,
    'menu_type' => $model->type_id
  ]) ?>

</div>
