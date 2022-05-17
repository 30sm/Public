<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\content\models\search\FaqSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Faq');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">
  <div class="card">
    <div class="card-header">
      <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
        'modelClass' => 'Faq',
      ]), ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card-body p-0">

      <?= GridView::widget([
        'layout' => "{items}\n{pager}",
        'options' => [
          'class' => ['gridview', 'table-responsive'],
        ],
        'tableOptions' => [
          'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width: 5%'],],


          [
            'attribute' => 'id',
            'options' => ['style' => 'width: 10%']
          ],
          [
            'attribute' => 'title',
            'value' => function ($model) {
              return Html::a(Html::encode($model->title), ['update', 'id' => $model->id]);
            },
            'format' => 'raw',
          ],
          [
            'attribute' => 'status',
            'options' => ['style' => 'width: 10%'],
            'value' => function ($model) {
              return $model->status ? common\models\Faq::$status_arr[$model->status] : null;
            },
            'filter' => common\models\Faq::$status_arr,
          ],
          // 'founding_date',
          // 'created_by',
          // 'updated_by',
          // 'created_at',
          // 'updated_at',
          [
            'class' => \common\widgets\ActionColumn::class,
            'options' => ['style' => 'width: 5%'],
            'template' => '{update} {delete}',
          ],
        ],
      ]); ?>

    </div>
    <div class="card-footer">
      <?= getDataProviderSummary($dataProvider) ?>
    </div>
  </div>

</div>