<?php
/**
 * Created by PhpStorm.
 * User: amstr1k
 * Date: 18.10.14
 * Time: 20:48
 */

namespace amstr1k\geography\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use amstr1k\geography\models\Country;
use amstr1k\geography\models\backend\CountrySearch;

class CountryController extends Controller
{
  public function actionIndex()
  {
    $searchModel        = new CountrySearch();
    $dataProvider       = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->sort = [
      'defaultOrder' => ['id' => SORT_DESC]
    ];
    return $this->render('index', [
      'searchModel'  => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionCreate()
  {
    $model = new Country();

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
   * Finds the Country model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Country the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Country::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
} 