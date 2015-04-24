# Balloon - A tiny file data access layer (csv, json, xml, yaml,...)

[![Latest Stable Version](https://poser.pugx.org/raphhh/balloon/v/stable.svg)](https://packagist.org/packages/raphhh/balloon)
[![Build Status](https://travis-ci.org/Raphhh/balloon.png)](https://travis-ci.org/Raphhh/balloon)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/balloon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/balloon/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/balloon/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/balloon/)
[![Total Downloads](https://poser.pugx.org/raphhh/balloon/downloads.svg)](https://packagist.org/packages/raphhh/balloon)
[![Reference Status](https://www.versioneye.com/php/raphhh:balloon/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:balloon/references)
[![License](https://poser.pugx.org/raphhh/balloon/license.svg)](https://packagist.org/packages/raphhh/balloon)


Balloon is a file manager with different kinds of data formats. 
It help you to get, add, modify or remove data from files like csv, json, xml or yaml.


## Installation

Execute [Composer](https://getcomposer.org/):

```
$ composer require raphhh/balloon
```

## Work with array

### Init

```php
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->json('path/to/my/file.json');
```

### Get data

```php
$dataList = $balloon->getAll();
var_dump($dataList); // contain an array of the data of your file
```

### Add data

```php
$balloon->add(['key1' => 'value1, ... ]);
$balloon->flush();
```

### Modify data

```php
$balloon->modify($id, ['key1' => 'value1, ... ]);
$balloon->flush();
```

### Remove data

```php
$balloon->remove($id);
$balloon->flush();
```

## Work with specific class

### Init

If you want to map the data to a specific class:

```php
$dataList = $balloon->getAll();
var_dump($dataList); // contain an array of the objects mapped to the data
```

### Get objects

```php
$dataList = $balloon->getAll();
var_dump($dataList); // contain an array of the data of your file
```

### Add object

```php
$balloon->add($myObject);
$balloon->flush();
```

### Modify object

```php
$balloon->modify($id, $myObject);
$balloon->flush();
```

### Remove object

```php
$balloon->remove($id);
$balloon->flush();
```
