<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\helpers\MultilingualHelper;
use common\models\Faq;
use kartik\date\DatePicker;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var common\models\Faq $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="faq-form">
  <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <?= $form->errorSummary($model) ?>
          <ul class="nav nav-tabs" role="tablist">
            <?php $i = 0;
            foreach ($languages as $key => $value):
              $i++; ?>
              <li class="nav-item <?php if ($i == 1) echo 'active'; ?>">
                <a class="nav-link <?php if ($i == 1) echo 'active'; ?>" data-toggle="tab" href="#<?= $key ?>"
                   role="tab"><?= $value ?>
                  <span class=\"input-group-addon\"></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="tab-content">
            <?php $i = 0;
            foreach ($languages as $key => $value):
              $i++; ?>
              <div class="tab-pane <?php if ($i == 1) echo 'active'; ?>" id="<?= $key ?>" role="tabpanel">
                <?= $form->field($model, MultilingualHelper::getFieldName('title', $key))->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, MultilingualHelper::getFieldName('annotation', $key))->textarea(['rows' => '6', 'maxlength' => true])->hint('Краткое описание - часть текста описания без HTM тегов (несколько строк)') ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <?= $form->field($model, 'status')->dropDownList(Faq::$status_arr) ?>
          <?= $form->field($model, 'founding_date')->widget(
            DatePicker::class,
            [
              'options' => ['placeholder' => 'Укажите дату ...'],
              'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose' => true,
                'todayBtn' => true,
                'format' => 'dd-mm-yyyy',
              ]
            ]
          ) ?>
          <?php // echo $form->field($model, 'created_by')->textInput() ?>
          <?php // echo $form->field($model, 'updated_by')->textInput() ?>
          <?php // echo $form->field($model, 'created_at')->textInput() ?>
          <?php // echo $form->field($model, 'updated_at')->textInput() ?>
          <div class="card-footer">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>