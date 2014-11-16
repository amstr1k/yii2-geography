<?php

namespace amstr1k\geography\models\backend;

use amstr1k\geography\models\Country;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amstr1k\geography\models\City;

/**
 * CitySearch represents the model behind the search form about `amstr1k\geography\models\City`.
 */
class CitySearch extends City
{

  public $country;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id'], 'integer'],
            [['country'], 'string'],
            [['title', 'country'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = City::find()->joinWith(['country']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
          'id' => $this->id,
          'country_id' => $this->country_id,
        ]);

        $query->andFilterWhere(['like', City::tableName() . '.title', $this->title])
          ->andFilterWhere(['like', Country::tableName() . '.title', $this->country]);

        return $dataProvider;
    }
}
