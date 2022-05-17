<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Faq $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Faq'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-view">
  <div class="card">
    <div class="card-header">
      <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
          'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
          'method' => 'post',
        ],
      ]) ?>
    </div>
    <div class="card-body">
      <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'id',
          'status',
          'founding_date',
          'created_by',
          'updated_by',
          'created_at',
          'updated_at',
        ],
      ]) ?>
    </div>
  </div>
</div>
