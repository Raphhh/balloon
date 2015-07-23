<?php
namespace Balloon\Mapper;

use Balloon\Mapper\resources\Bar;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ICanBoogie\Inflector;
use JMS\Serializer\SerializerBuilder;

/**
 * Class DataMapperTest
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DataMapperTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    public function testMapDataListWithCommonObject()
    {
        $dataMapper = new DataMapper($this->provideSerializer(), Inflector::get(),'Balloon\Mapper\resources\Bar');
        $result = $dataMapper->mapDataList([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertInstanceOf('Balloon\Mapper\resources\Bar', $result[0]);
        $this->assertSame('value1', $result[0]->key1);
        $this->assertInstanceOf('Balloon\Mapper\resources\Bar', $result[1]);
        $this->assertSame('value2', $result[1]->key1);
    }

    public function testMapDataListWithoutClass()
    {
        $dataMapper = new DataMapper($this->provideSerializer(), Inflector::get());
        $result = $dataMapper->mapDataList([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUnmapObjectsWithCommonObject()
    {
        $data = [];
        $data[] = new Bar('value1');
        $data[] = new Bar('value2');

        $dataMapper = new DataMapper($this->provideSerializer(), Inflector::get());
        $result = $dataMapper->unmapObjects($data);
        $this->assertCount(2, $result);
        $this->assertSame('value1', $result[0]['key1']);
        $this->assertSame('value2', $result[1]['key1']);
    }

    public function testUnmapObjectsWithoutCollection()
    {
        $dataMapper = new DataMapper($this->provideSerializer(), Inflector::get(),'Balloon\Mapper\resources\Bar');
        $result = $dataMapper->mapDataList([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertTrue(is_array($result));
    }

    public function testUnmapObjectsWithCollection()
    {
        $dataMapper = new DataMapper($this->provideSerializer(), Inflector::get(),'Balloon\Mapper\resources\Foo');
        $result = $dataMapper->mapDataList([['key1' => 'value1'], ['key1' => 'value2']]);
        $this->assertInstanceOf('Balloon\Mapper\resources\Foos', $result);
    }

    /**
     *
     * @return \JMS\Serializer\Serializer
     */
    private function provideSerializer()
    {
        return SerializerBuilder::create()->build();
    }
}
