<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\helpers\MultilingualHelper;
use common\models\MenuSecond;
use kartik\date\DatePicker;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */
/* @var array $parents common\models\Menu */
/* @var common\models\Menu $menu_type type_id */

?>

<div class="menu-form">

  <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <?= $form->errorSummary($model); ?>
          <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Если нет необходимости в специальном ЧПУ, оставляем пустым, будет сгенерирован на основании английского названия') ?>
          <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
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
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <?= $form->field($model, 'status')->dropDownList(\common\models\MenuSecond::statuses()) ?>

          <?= $form->field($model, 'parent_id')->dropDownList($parents, ['prompt' => ''])->label(Yii::t('common', 'Parent Category')) ?>

          <?= $form->field($model, 'type_id')->hiddenInput(['value' => $menu_type])->label(false) ?>
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
