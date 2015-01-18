<?php
/**
 * Created by PhpStorm.
 * User: amstr1k
 * Date: 18.10.14
 * Time: 20:48
 */

namespace amstr1k\geography\controllers;

use amstr1k\geography\models\Country;
use amstr1k\geography\Module;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use amstr1k\geography\models\City;
use amstr1k\geography\models\backend\CitySearch;
use yii\helpers\Json;

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

  public function actionCreate()
  {
    $model = new City();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
      ]);
    }
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    } else {
      return $this->render('update', [
        'model' => $model,
      ]);
    }
  }

  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the City model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return City the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = City::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

  public function actionAjaxGetCountry($search = null, $id = null)
  {
    $out = ['more' => false];
    if (!is_null($search)) {
      $query = Yii::$app->db;
      $data = $query->createCommand('SELECT id, title as text from country where title like "%'. $search .'%" limit 20 ')
        ->queryAll();
      $out['results'] = array_values($data);
    }
    elseif ($id > 0) {
      $out['results'] = ['id' => $id, 'text' => Country::findOne(['id' => $id])->title];
    }
    else {
      $out['results'] = ['id' => 0, 'text' => Module::t('geography', 'NO_MATCHING_RECORDS_FOUND')];
    }
    echo Json::encode($out);
  }
} 