<?php
/**
 * Created by PhpStorm.
 * User: amstr1k
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace amstr1k\geography\models;

use yii\db\ActiveQuery;

class CountryQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['status' => Country::STATUS_PUBLISHED]);
        $this->andWhere('country.published_at < NOW()');
        return $this;
    }
} 