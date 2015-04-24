<?php
namespace Balloon\Mapper;

use Balloon\Mapper\resources\Class1;
use Balloon\Mapper\resources\Class2;

/**
 * Class DataMapperTest
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DataMapperTest extends \PHPUnit_Framework_TestCase
{

    public function testTieWithIArrayCastable()
    {
        $dataMapper = new DataMapper('Balloon\Mapper\resources\Class1');
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertInstanceOf('Balloon\Mapper\resources\Class1', $result[0]);
        $this->assertSame('value1', $result[0]->getKey1());
        $this->assertInstanceOf('Balloon\Mapper\resources\Class1', $result[1]);
        $this->assertSame('value2', $result[1]->getKey1());
    }

    public function testTieWithCommonObject()
    {
        $dataMapper = new DataMapper('Balloon\Mapper\resources\Class2');
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertInstanceOf('Balloon\Mapper\resources\Class2', $result[0]);
        $this->assertSame('value1', $result[0]->getKey1());
        $this->assertInstanceOf('Balloon\Mapper\resources\Class2', $result[1]);
        $this->assertSame('value2', $result[1]->getKey1());
    }

    public function testTieWithoutClass()
    {
        $dataMapper = new DataMapper();
        $result = $dataMapper->tie([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUntieWithIArrayCastable()
    {
        $data = [];
        $data[] = new Class1('value1');
        $data[] = new Class1('value2');

        $dataMapper = new DataMapper();
        $result = $dataMapper->untie($data);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUntieWithCommonObject()
    {
        $data = [];
        $data[] = new Class2('value1');
        $data[] = new Class2('value2');

        $dataMapper = new DataMapper();
        $result = $dataMapper->untie($data);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }
}
