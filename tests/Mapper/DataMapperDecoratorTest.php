<?php
namespace Balloon\Mapper;

use Balloon\Bridge\DummyFileReader;
use Balloon\Decorator\Json;

/**
 * Class DataMapperDecoratorTest
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DataMapperDecoratorTest extends \PHPUnit_Framework_TestCase
{

    public function testRead()
    {
        $data = [['abc']];
        $result = [['def']];

        $fileReader = new Json(new DummyFileReader());
        $fileReader->write($data);

        $dataMapper = $this->getMock('Balloon\Mapper\DataMapper');
        $dataMapper->expects($this->once())
            ->method('tie')
            ->with($data)
            ->will($this->returnValue($result));

        $dataMapperDecorator = new DataMapperDecorator($fileReader, $dataMapper);
        $this->assertSame($result, $dataMapperDecorator->read());
    }

    public function testWrite()
    {
        $data = [['abc']];
        $result = [['def']];

        $fileReader = new Json(new DummyFileReader());

        $dataMapper = $this->getMock('Balloon\Mapper\DataMapper');
        $dataMapper->expects($this->once())
            ->method('untie')
            ->with($data)
            ->will($this->returnValue($result));

        $dataMapperDecorator = new DataMapperDecorator($fileReader, $dataMapper);
        $this->assertSame(29, $dataMapperDecorator->write($data));
        $this->assertSame($result, $fileReader->read());
    }
}