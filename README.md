Geography module for Yii 2
========================================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist amstr1k/yii2-geography "*"
```

or add

```
"amstr1k/yii2-geography": "*"
```

to the require section of your `composer.json` file.

Configuration
-------------

Add yii2-geography to module section of each application config:

```php
'modules' => [
  'geography' => [
    'class' => 'amstr1k\geography\Module'
]
```

Add yii2-geography to console config:

```php
'geonames-integration'=>[
  'class'=>'amstr1k\geography\commands\GeoNamesController'
],
```

Apply migrations with console command
`yii migrate --migrationPath=@amstr1k/geography/migrations`

Run command to import countries and cities
`yii geonames-integration`
