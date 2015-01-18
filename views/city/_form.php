<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use amstr1k\geography\models\Country;
use amstr1k\geography\Module;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model amstr1k\geography\models\City */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="city-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

  <?php $url = Url::to(['ajax-get-country']);

  $initScript = <<< SCRIPT
    function (element, callback) {
        var id=\$(element).val();
        if (id !== "") {
            \$.ajax("{$url}?id=" + id, {
                dataType: "json"
            }).done(function(data) { callback(data.results);});
        }
    }
SCRIPT;

  echo $form->field($model, 'country_id')->widget(Select2::classname(), [
    'options'       => ['placeholder' => Module::t('geography', 'SEARCH_COUNTRY')],
    'language'      => Yii::$app->language == 'ru-RU' ? 'ru' : 'en',
    'pluginOptions' => [
      'allowClear'         => true,
      'minimumInputLength' => 3,
      'ajax'               => [
        'url'      => $url,
        'dataType' => 'json',
        'data'     => new JsExpression('function(term,page) { return {search:term}; }'),
        'results'  => new JsExpression('function(data,page) { return {results:data.results}; }'),
      ],
      'initSelection'      => new JsExpression($initScript)
    ],
  ])->label(Module::t('geography', 'COUNTRY'));
  ?>

  <?= $form->field($model, 'is_published')->label(Module::t('geography', 'IS_PUBLISHED'))->checkbox() ?>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Module::t('geography', 'CREATE') : Module::t('geography',
        'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
