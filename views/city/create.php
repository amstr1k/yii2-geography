<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model amstr1k\geography\models\City */

$this->title = Yii::t('geography', 'CREATE_CITY');
$this->params['breadcrumbs'][] = ['label' => Yii::t('geography', 'CITIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create">

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
