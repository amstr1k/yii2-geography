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

  <p>
    <?= Html::a(
      Yii::t('geography', 'CREATE_COUNTRY'),
      ['create'],
      ['class' => 'btn btn-success']
    ) ?>
  </p>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
      ['class' => 'yii\grid\SerialColumn'],
      'id',
      'title',
      [
        'options' => ['style' => 'width: 5%'],
        'class'   => 'yii\grid\ActionColumn',
        'template'=>'{update} {delete}'
      ],
    ],
  ]); ?>

</div>
