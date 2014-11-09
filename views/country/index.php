<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel amstr1k\geography\models\backend\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('geography', 'COUNTRIES');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
      ['class' => 'yii\grid\SerialColumn'],
      'id',
      'title',
      [
        'options' => ['style' => 'width: 10%'],
        'class'   => 'yii\grid\ActionColumn'
      ],
    ],
  ]); ?>

</div>
