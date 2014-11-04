<?php
/**
 * Created by PhpStorm.
 * User: amstr1k
 * Date: 18.10.14
 * Time: 20:48
 */

namespace amstr1k\geography\controllers;

use backend\models\search\CountrySearch;
use Yii;
use yii\web\Controller;

class CountryController extends Controller
{
  public function actionIndex()
  {
    $searchModel = new CountrySearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->sort = [
      'defaultOrder'=>['id'=>SORT_DESC]
    ];
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }
} 