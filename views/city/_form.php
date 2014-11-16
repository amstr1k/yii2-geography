<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use amstr1k\geography\models\Country;
use amstr1k\geography\Module;

/* @var $this yii\web\View */
/* @var $model amstr1k\geography\models\City */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="city-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

  <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(
    Country::find()->where(['is_published' => Country::COUNTRY_PUBLISHED])->all(),
    'id',
    'title'
  ), ['prompt' => '']) ?>

  <?= $form->field($model, 'is_published')->label(Module::t('geography', 'IS_PUBLISHED'))->checkbox() ?>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Module::t('geography', 'CREATE') : Module::t('geography',
        'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
