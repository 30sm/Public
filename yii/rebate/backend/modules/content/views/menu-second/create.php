<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var array $parents common\models\Menu */
/* @var common\models\Menu $menu_type type_id */

$this->title = $menu_type ? 'Створити пункт меню кабінету' : 'Створити пункт головного меню';
$this->params['breadcrumbs'][] = !$menu_type ? ['label' => 'Меню', 'url' => ['index']] : ['label' => 'Меню', 'url' => ['index', 'menu' => $menu_type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

  <!-- <h1><?php //echo Html::encode($this->title) ?></h1> -->

  <?= $this->render('_form', [
    'model' => $model,
    'parents' => $parents,
    'languages' => $languages,
    'menu_type' => $menu_type,
  ]) ?>

</div>
