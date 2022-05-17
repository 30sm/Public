<?php

/**
 * @var yii\web\View $this
 * @var common\models\Faq $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Faq',
  ]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Faq'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="faq-update">

  <?= $this->render('_form', [
    'model' => $model,
    'languages' => $languages,
  ]) ?>

</div>