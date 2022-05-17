<?php

use common\grid\EnumColumn;
use common\models\MenuSecond;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var int $menu type_id */

$this->title = Yii::t('backend', 'Second menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

  <!-- <h1><?php //echo Html::encode($this->title) ?></h1> -->

  <p>
    <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
      'modelClass' => 'MenuSecond',
    ]), ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
      'id' => 'sorttable',
      'class' => 'grid-view table-responsive',
    ],
    'rowOptions' => function ($model) {
      return ['data-orders' => $model->order];
    },
    'columns' => [
      [
        'class' => 'backend\components\OrdersColumn',
        'action' => '/content/menu/orders'
      ],
//            'order',
      [
        'attribute' => 'title',
        'value' => function ($model) {
          return Html::a($model->title, ['update', 'id' => $model->id]);
        },
        'format' => 'raw',
      ],
      'url',
      [
        'attribute' => 'parent_id',
        'value' => function ($model) {
          return $model->parent ? $model->parent->title : ' - ';
        }, 'filter' => $menu ? ArrayHelper::map(MenuSecond::find()->cabinetMenu()->all(), 'id', 'title') : ArrayHelper::map(MenuSecond::find()->mainMenu()->all(), 'id', 'title'),
        'label' => Yii::t('common', 'Батьківська категорія'),
      ],
      [
        'class' => EnumColumn::class,
        'attribute' => 'status',
        'options' => ['style' => 'width: 10%'],
        'enum' => MenuSecond::statuses(),
        'filter' => MenuSecond::statuses(),
      ],
      [
        'class' => EnumColumn::class,
        'attribute' => 'subscription',
        'options' => ['style' => 'width: 10%'],
        'enum' => MenuSecond::subscriptionMenu(),
        'filter' => MenuSecond::subscriptionMenu(),
        'visible' => $menu,
      ],
      ['class' => 'yii\grid\ActionColumn'],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
