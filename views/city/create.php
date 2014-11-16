<?php

use amstr1k\geography\Module;

/* @var $this yii\web\View */
/* @var $model amstr1k\geography\models\City */

$this->title                   = Module::t('geography', 'CREATE_CITY');
$this->params['breadcrumbs'][] = ['label' => Module::t('geography', 'CITIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create">

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
