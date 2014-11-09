<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel amstr1k\geography\models\backend\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('geography', 'City');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">
  <?php \yii\widgets\Pjax::begin(); ?>
  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
      ['class' => 'yii\grid\SerialColumn'],
      'id',
      'title',
      [
        'attribute' => 'country',
        'value'     => function ($model) {
          return $model->country ? $model->country->title : null;
        },
      ],
      [
        'options' => ['style' => 'width: 10%'],
        'class'   => 'yii\grid\ActionColumn'
      ],
    ],
  ]);
  ?>
  <?php \yii\widgets\Pjax::end(); ?>

</div>
