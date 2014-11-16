<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace amstr1k\geography\models;

use amstr1k\geography\models;
use yii\db\ActiveQuery;

class CityQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere('city.published_at < NOW()');
        return $this;
    }
} 