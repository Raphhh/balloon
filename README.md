# Balloon - A tiny DAL & ORM for files (csv, json, xml, yaml,...)

[![Latest Stable Version](https://poser.pugx.org/raphhh/balloon/v/stable.svg)](https://packagist.org/packages/raphhh/balloon)
[![Build Status](https://travis-ci.org/Raphhh/balloon.png)](https://travis-ci.org/Raphhh/balloon)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/balloon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/balloon/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/balloon/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/balloon/)
[![Total Downloads](https://poser.pugx.org/raphhh/balloon/downloads.svg)](https://packagist.org/packages/raphhh/balloon)
[![Reference Status](https://www.versioneye.com/php/raphhh:balloon/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:balloon/references)
[![License](https://poser.pugx.org/raphhh/balloon/license.svg)](https://packagist.org/packages/raphhh/balloon)


Balloon is a file manager which supports different kinds of data formats. 
It help you to get, add, modify or remove data from files like csv, json, xml or yaml.

You can use it as a Data Access Layer (DAL) and work with arrays, or use it as an Object Relational Mapping (ORM) and work with objects.


## Installation

Execute [Composer](https://getcomposer.org/):

```
$ composer require raphhh/balloon
```

## DAL: Work with arrays

### Init

```php
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->create('path/to/my/file.json');
```

### Get data

```php
$dataList = $balloon->getAll();
var_dump($dataList); // contains an array of the data of your file
```

### Add data

```php
$balloon->add(['key1' => 'value1', ... ]);
$balloon->flush();
```

### Modify data

```php
$balloon->modify($id, ['key1' => 'value1', ... ]);
$balloon->flush();
```

### Remove data

```php
$balloon->remove($id);
$balloon->flush();
```

## ORM: Work with objects

### Init

If you want to map the data to a specific class:

```php
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->create('path/to/my/file.json', 'My\Class', 'pkPropertyName');
```

### Get objects

```php
$objects = $balloon->getAll();
var_dump($objects); // contains an array of the objects of your file
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

## Cache

The cache of Balloon prevents to access to the same file more than once when you try to read it.

```php
$balloon->getAll(); //first time, we read the file
$balloon->getAll(); //next times, we read the cache
```

You can invalidate the cache with the method "Balloon::invalidate()".

```php
$balloon->getAll(); //we read the file
$balloon->invalidate();
$balloon->getAll(); //we read the file
```

## Unit of work

The unit of work of Balloon prevents to access to the same file more than once when you try to write it. 
So, that means you have to flush Balloon if you want to write into the file.

```php
$balloon->add($data); //nothing added into the file
$balloon->flush(); //now only, we put $data into the file
```

## Object Mapping

Balloon uses two strategies to map the data to an object:

 1. Your object implements IArrayCastable, and returns directly the data.
 2. Your object use public properties and can be cast to an array.
 

An example with IArrayCastable:
```php
class Foo implements IArrayCastable
{

    private $key1 = 'value1';
    private $key2 = 'value2';
    
    
    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
```


//todo
tester les primary key
rajouter addLIst, removeList,...
rajouter xml, yaml, csv