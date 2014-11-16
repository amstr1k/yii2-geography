<?php

use amstr1k\geography\Module;

/* @var $this yii\web\View */
/* @var $model amstr1k\geography\models\Country */

$this->title                   = Module::t('geography', 'EDIT_COUNTRY');
$this->params['breadcrumbs'][] = ['label' => Module::t('geography', 'COUNTRIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
