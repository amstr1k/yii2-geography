<?php
/**
 * Created by PhpStorm.
 * User: amstr1k
 * Date: 18.10.14
 * Time: 20:48
 */

namespace amstr1k\geography\controllers;

use amstr1k\geography\models\backend\CitySearch;
use Yii;
use yii\web\Controller;

class CityController extends Controller
{
  public function actionIndex()
  {
    $searchModel = new CitySearch();
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