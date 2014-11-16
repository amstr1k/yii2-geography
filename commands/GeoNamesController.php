<?php

namespace amstr1k\geography\commands;

use amstr1k\geography\models\City;
use amstr1k\geography\models\Country;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;

class GeoNamesController extends Controller
{
  /**
   * @inheritdoc
   */
  public $defaultAction = 'integration';

  public $baseUrl = 'http://download.geonames.org/export/dump/';

  public $tempDir = 'backend/assets/geonames/';

  public $files = [
    'geoname_city'             => 'cities1000.zip',
    'geoname_country'          => 'countryInfo.txt',
    'geoname_alternative_name' => 'alternateNames.zip'
  ];

  public function actionIntegration()
  {
    $dsn_array_attribute = explode('=', Yii::$app->db->dsn);
    $db_name             = $dsn_array_attribute[2];
    $table_prefix        = Yii::$app->db->tablePrefix;

    BaseFileHelper::createDirectory($this->tempDir, 0777);

    foreach($this->files as $table_name => $filename)
    {
      $zip_name = $this->tempDir . $filename;
      if(!file_exists($zip_name))
      {
        if(!$tmp_file = fopen($zip_name, 'w'))
        {
          return;
        }

        $curl = curl_init();
        $url  = $this->baseUrl . $filename;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FILE, $tmp_file);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_exec($curl);
        curl_close($curl);
        fclose($tmp_file);
      }

      if(preg_match('/\.zip$/', $zip_name))
      {
        $zip = new \ZipArchive();
        $zip->open($zip_name);
        $zip->extractTo($this->tempDir);
      }

      $unziped_name = str_replace('.zip', '.txt', $zip_name);

      if($table_name == 'geoname_alternative_name')
      {
        $new_unzipped_name = $this->tempDir . 'ru_names.txt';
        `grep -P '^\d+\t\d+\tru\t' {$unziped_name} > {$new_unzipped_name}`;
        $unziped_name = $new_unzipped_name;
      }
      else
      {
        if($table_name == 'geoname_country')
        {
          $new_unzipped_name = $this->tempDir . 'countryInfo_fixed.txt';
          `grep -Pv '^#.*$' {$unziped_name} > {$new_unzipped_name}`;
          $unziped_name = $new_unzipped_name;
        }
      }

      $fields = ArrayHelper::getColumn(
        Yii::$app->db->createCommand("SHOW COLUMNS FROM {$table_prefix}{$table_name}")->query(),
        'Field'
      );

      Yii::$app->db->createCommand("TRUNCATE {$table_prefix}{$table_name}")->query();
      $sql = "LOAD DATA LOCAL INFILE '" . $unziped_name . "' INTO TABLE " . $table_prefix . $table_name . ' CHARACTER SET utf8 FIELDS TERMINATED BY \"\t\" LINES TERMINATED BY \"\n\" (' . implode(', ',
          $fields) . ')';

      $db = Yii::$app->db;

      $cmd = "mysql --local-infile=1 -u{$db->username} -p{$db->password} {$db_name} -e \"$sql\" \n";
      `$cmd`;
    }

    BaseFileHelper::removeDirectory($this->tempDir);

    Yii::$app->db->createCommand("DELETE FROM {$table_prefix}geoname_country WHERE geoname_id = 0")->query();

    $sql = "SELECT {$table_prefix}geoname_country.*,
            (SELECT alternate_name FROM {$table_prefix}geoname_alternative_name WHERE {$table_prefix}geoname_alternative_name.geoname_id = {$table_prefix}geoname_country.geoname_id LIMIT 0,1) as ru_name
            FROM {$table_prefix}geoname_country ";

    $geoname_countries = Yii::$app->db->createCommand($sql)->query();
    foreach($geoname_countries as $geoname_country)
    {
      if(!$country = Country::findOne(['iso' => $geoname_country['iso']]))
      {
        $country = new Country();
      }

      $attributes = [
        'iso'          => $geoname_country['iso'],
        'title'        => $geoname_country['ru_name'],
        'worldpart'    => $geoname_country['continent'],
        'geoname_id'   => $geoname_country['geoname_id'],
        'is_published' => 1
      ];

      if(!$country->getIsNewRecord())
      {
        $attributes = ['geoname_id' => $geoname_country['geoname_id']];
      }

      $capital_id = $this->getCapitalIdByName($geoname_country['capital'], $geoname_country['iso'], $table_prefix);

      if(($capital_id) && ($country->capital_id <> $capital_id))
      {
        $attributes['capital_id'] = $capital_id;
      }

      $country->setAttributes($attributes);
      $country->save();
    }

    $country_ids = [];

    foreach(Yii::$app->db->createCommand("SELECT id, iso FROM {$table_prefix}country")->query() as $item)
    {
      $country_ids[$item['iso']] = $item['id'];
    }

    $sql = "SELECT
              {$table_prefix}geoname_city.geoname_id as geoname_id,
              {$table_prefix}geoname_city.alternate_names as alternate_names,
              {$table_prefix}geoname_city.latitude as latitude,
              {$table_prefix}geoname_city.longitude as longitude,
              {$table_prefix}geoname_city.country_code as country_code,
              {$table_prefix}geoname_alternative_name.alternate_name as ru_name
            FROM {$table_prefix}geoname_city
            JOIN {$table_prefix}geoname_alternative_name ON {$table_prefix}geoname_alternative_name.geoname_id = {$table_prefix}geoname_city.geoname_id
            GROUP BY geoname_id ";

    $geoname_cities = Yii::$app->db->createCommand($sql)->query();

    foreach($geoname_cities as $geoname_city)
    {
      if(!$geoname_city['country_code'])
      {
        continue;
      }

      if(!isset($country_ids[$geoname_city['country_code']]))
      {
        continue;
      }

      if(!$geoname_city['geoname_id'])
      {
        continue;
      }

      $russian_city_title = trim($geoname_city['ru_name']);
      $russian_city_title = mb_convert_case($russian_city_title, MB_CASE_TITLE, 'UTF-8');

      if(!preg_match('/[а-яА-я]/', $russian_city_title))
      {
        continue;
      }

      if(!$city = City::findOne(['geoname_id' => $geoname_city['geoname_id']]))
      {
        $city = new City();
      }

      $identifier = strtolower($this->translitRussian($russian_city_title));
      $identifier = str_replace('  ', ' ', $identifier);
      $identifier = str_replace(' ', '-', $identifier);

      $attributes = [
        'title'        => $russian_city_title,
        'latitude'     => $geoname_city['latitude'],
        'longitude'    => $geoname_city['longitude'],
        'identifier'   => $identifier,
        'geoname_id'   => $geoname_city['geoname_id'],
        'country_id'   => $country_ids[$geoname_city['country_code']],
        'is_published' => 1,
      ];

      if(!$city->getIsNewRecord())
      {
        unset($attributes['title']);
        unset($attributes['identifier']);
        unset($attributes['country_id']);
        unset($attributes['is_published']);
      }

      $city->setAttributes($attributes);
      $city->save();
    }
  }

  function getCapitalIdByName($capital_name, $country_iso, $table_prefix)
  {
    $sql = "SELECT cc.id as capital_id
            FROM " . $table_prefix . "city as cc
            JOIN " . $table_prefix . "geoname_city AS gcc ON gcc.geoname_id = cc.geoname_id
            WHERE gcc.name= \"" . $capital_name . "\" AND gcc.country_code=\"" . $country_iso . "\"";
    $capital_id = Yii::$app->db->createCommand($sql)->queryOne();
    if($capital_id)
    {
      return $capital_id;
    }
    else
    {
      return false;
    }
  }

  function translitRussian($input, $encoding = 'utf-8')
  {
    $encoding = strtolower($encoding);
    if($encoding != 'utf-8')
    {
      $input = iconv($encoding, 'utf-8', $input);
    }

    $arrRus = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м',
      'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь',
      'ы', 'ъ', 'э', 'ю', 'я',
      'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М',
      'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ь',
      'Ы', 'Ъ', 'Э', 'Ю', 'Я'];
    $arrEng = ['a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm',
      'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'c', 'ch', 'sh', 'sch', '',
      'y', '', 'e', 'yu', 'ya',
      'A', 'B', 'V', 'G', 'D', 'E', 'JO', 'ZH', 'Z', 'I', 'Y', 'K', 'L', 'M',
      'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'KH', 'C', 'CH', 'SH', 'SCH', '',
      'Y', '', 'E', 'YU', 'YA'];

    $result = str_replace($arrRus, $arrEng, $input);

    if($encoding != 'utf-8')
    {
      return iconv('utf-8', $encoding, $result);
    }
    else
    {
      return $result;
    }
  }
}