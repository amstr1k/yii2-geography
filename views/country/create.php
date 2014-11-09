<?php

/* @var $this yii\web\View */
/* @var $model amstr1k\geography\models\Country */

$this->title = Yii::t('geography', 'CREATE_COUNTRY');
$this->params['breadcrumbs'][] = ['label' => Yii::t('geography', 'COUNTRIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
