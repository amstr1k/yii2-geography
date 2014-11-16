<?php

use yii\helpers\Html;
use yii\grid\GridView;
use amstr1k\geography\Module;

/* @var $this yii\web\View */
/* @var $searchModel amstr1k\geography\models\backend\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Module::t('geography', 'CITIES');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

  <p>
    <?= Html::a(
      Module::t('geography', 'CREATE_CITY'),
      ['create'],
      ['class' => 'btn btn-success']
    ) ?>
  </p>

  <?php \yii\widgets\Pjax::begin(); ?>
  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
      ['class' => 'yii\grid\SerialColumn'],
      'id',
      'title',
      [
        'attribute' => 'country_id',
        'value'     => function ($model) {
          return $model->country ? $model->country->title : null;
        },
      ],
      [
        'options'  => ['style' => 'width: 5%'],
        'class'    => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}'
      ],
    ],
  ]);
  ?>
  <?php \yii\widgets\Pjax::end(); ?>

</div>
