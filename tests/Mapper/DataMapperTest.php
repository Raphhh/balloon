<?php
namespace Balloon\Mapper;

use Balloon\Mapper\resources\Foo;
use Balloon\Mapper\resources\Bar;
use ICanBoogie\Inflector;

/**
 * Class DataMapperTest
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DataMapperTest extends \PHPUnit_Framework_TestCase
{

    public function testTieWithIArrayCastable()
    {
        $dataMapper = new DataMapper(Inflector::get(),'Balloon\Mapper\resources\Foo');
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertInstanceOf('Balloon\Mapper\resources\Foo', $result[0]);
        $this->assertSame('value1', $result[0]->getKey1());
        $this->assertInstanceOf('Balloon\Mapper\resources\Foo', $result[1]);
        $this->assertSame('value2', $result[1]->getKey1());
    }

    public function testTieWithCommonObject()
    {
        $dataMapper = new DataMapper(Inflector::get(),'Balloon\Mapper\resources\Bar');
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertInstanceOf('Balloon\Mapper\resources\Bar', $result[0]);
        $this->assertSame('value1', $result[0]->key1);
        $this->assertInstanceOf('Balloon\Mapper\resources\Bar', $result[1]);
        $this->assertSame('value2', $result[1]->key1);
    }

    public function testTieWithoutClass()
    {
        $dataMapper = new DataMapper(Inflector::get());
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUntieWithIArrayCastable()
    {
        $data = [];
        $data[] = new Foo('value1');
        $data[] = new Foo('value2');

        $dataMapper = new DataMapper(Inflector::get());
        $result = $dataMapper->untie($data);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUntieWithCommonObject()
    {
        $data = [];
        $data[] = new Bar('value1');
        $data[] = new Bar('value2');

        $dataMapper = new DataMapper(Inflector::get());
        $result = $dataMapper->untie($data);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUntieWithoutCollection()
    {
        $dataMapper = new DataMapper(Inflector::get(),'Balloon\Mapper\resources\Bar');
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertInstanceOf('ArrayObject', $result);
    }

    public function testUntieWithCollection()
    {
        $dataMapper = new DataMapper(Inflector::get(),'Balloon\Mapper\resources\Foo');
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertInstanceOf('Balloon\Mapper\resources\Foos', $result);
    }
}
