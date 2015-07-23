# Balloon - A tiny file data access layer (csv, json, xml, yaml)

[![Latest Stable Version](https://poser.pugx.org/raphhh/balloon/v/stable.svg)](https://packagist.org/packages/raphhh/balloon)
[![Build Status](https://travis-ci.org/Raphhh/balloon.png)](https://travis-ci.org/Raphhh/balloon)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/balloon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/balloon/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/balloon/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/balloon/)
[![Total Downloads](https://poser.pugx.org/raphhh/balloon/downloads.svg)](https://packagist.org/packages/raphhh/balloon)
[![Reference Status](https://www.versioneye.com/php/raphhh:balloon/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:balloon/references)
[![License](https://poser.pugx.org/raphhh/balloon/license.svg)](https://packagist.org/packages/raphhh/balloon)


Balloon is a file data access layer which supports different kinds of data formats.

It help you to get, add, modify or remove data (CRUD basic actions) from files like csv, json, xml or yaml.

You can work with objects or with arrays. With arrays, Balloon will extract the data of the file and gives you a list of array for every data. With objects, Balloon will map these data with objects of a specific class of your choice. Then, you can also work with specific collections of objects.

Finally, you can work with different file system abstractions (local, cloud,...). Balloon provides an adapter to use [Gaufrette](https://github.com/KnpLabs/Gaufrette) (but you can also add your own adapter).


## Installation

Execute [Composer](https://getcomposer.org/):

```
$ composer require raphhh/balloon
```

## Supported file formats

 - json
 - yaml
 - xml (todo)
 - csv (todo)

## CRUD actions

### Work with objects

With the object usage, Balloon will map data of your file into objects of a specific class.

#### Init

```php
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->create('path/to/my/file.json', 'My\Class', 'pkPropertyName');
```

(Note that the pk is not mandatory. Id of object will be simple index.)


#### Get objects

```php
$objects = $balloon->getAll();
var_dump($objects); // contains an array of the objects of your file
```

#### Add object

```php
$balloon->add($myObject);
$balloon->flush();
```

#### Modify object

```php
$balloon->modify($id, $myObject);
$balloon->flush();
```

#### Remove object

```php
$balloon->remove($id);
$balloon->flush();
```

### Work with arrays

With the array usage, Balloon will map data of your file into arrays.

#### Init

```php
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->create('path/to/my/file.json');
```

#### Get data

```php
$dataList = $balloon->getAll();
var_dump($dataList); // contains an array of the data of your file
```

#### Add data

```php
$balloon->add(['key1' => 'value1']);
$balloon->flush();
```

#### Modify data

```php
$balloon->modify($id, ['key1' => 'value1']);
$balloon->flush();
```

#### Remove data

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

You can also rollback your modifications (only if you have not flushed!).

```php
$balloon->add($data); //nothing added into the file
$balloon->clear(); //your previous modification has been canceled.
```

## Object Mapping

## Object

Balloon uses the [JMS Serializer](http://jmsyst.com/libs/serializer) to serialize the objects.

This library can work with yaml, xml or annotations to map the data to their object.

For example, if you use annotations:

```php
namespace Bar;

//declare the annotation namespace
use JMS\Serializer\Annotation\Type;

//register the doctrine auto load
AnnotationRegistry::registerLoader('class_exists');

//declare the data class
class Foo
{
    /**
     * @Type("string")
     */
    public $name;
}

//declare the class in Balloon
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->create('path/to/my/file.json', 'Bar\Foo');
```

You can redefine the default Serializer in the second arg of the Balloon Factory:

```php
$serializer = JMS\Serializer\SerializerBuilder::create()->build();
$balloonFactory = new BalloonFactory(null, $serializer);
```

For more information about JMS Serializer, see the [documentation](http://jmsyst.com/libs/serializer).

## Collection

By default, if you work with a collection of data, Balloon returns an array of these data.

But if you work with objects for data, you can also work with specific collection class. 
You just have to declare a class with the same name as your data class, but in plural.
This class will receive an array of the objects as first arg of the constructor.

For example, if you work with data object of the class 'Foo', you can declare a class 'Foos' as a collection.


```php
//declare the data class
class Foo
{
    ...
}
```

```php
//declare the collection
class Foos extends \ArrayObject
{
    ...
}
```

```php
//run Balloon
$balloonFactory = new BalloonFactory();
$balloon = $balloonFactory->create('path/to/my/file.json', 'Foo');
$balloon->getAll(); //return an instance of Foos
```


## Filesystem abstraction

By default, Balloon will read and write locally. But you can use other drivers, and work with other kind of filesystems.

The best way to proceed is to use a library such [Gaufrette](https://github.com/KnpLabs/Gaufrette). 
Balloon provides an adapter for this library.

```php
//declare Gaufrette
$adapter = new LocalAdapter('/var/media');
$filesystem = new Filesystem($adapter);

//declare Ballooon
$gaufretteAdapter = new GaufretteAdapter($filesystem)
$balloonFactory = new BalloonFactory($gaufretteAdapter);
$balloon = $balloonFactory->create('path/to/my/file.json');
```


## Extending Balloon

You can extend Balloon by creating a child:
```php
class BeachBall extends Balloon
{
    //your own methods here...
}
```

But to instantiate easily this new class, you should also extend BalloonFactory and specify the name of your class:

```php
class BeachBallFactory extends BalloonFactory
{
    protected function getClassName()
    {
        return 'BeachBall';
    }
}
```

Then you can use BeachBallFactory to create BeachBall in a same way than Balloon:

```php
$beachBallFactory = new BeachBallFactory();
$beachBall = $beachBallFactory->create('path/to/my/file.json');
$beachBall->getAll();
```
