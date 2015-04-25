<?php
namespace Balloon\Manager;

use Balloon\Bridge\DummyFileReader;
use Balloon\Decorator\Json;

/**
 * Class FileManagerTest
 * @package Balloon\Manager
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileManagerTest extends \PHPUnit_Framework_TestCase
{

    public function testGetAll()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->getAll();
        $this->assertSame($data, $result);
    }

    public function testGetAllEmpty()
    {
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->getAll();
        $this->assertSame([], $result);
    }

    public function testGet()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->get(0);
        $this->assertSame($data[0], $result);
    }

    public function testGetEmpty()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->get(2);
        $this->assertNull($result);
    }

    public function testHas()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->has(0);
        $this->assertTrue($result);
    }

    public function testHasEmpty()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->has(2);
        $this->assertFalse($result);
    }

    public function testAdd()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->add(['key3' => 'value3']);
        $this->assertSame(116, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
                ['key1' => 'value1'],
                ['key2' => 'value2'],
                ['key3' => 'value3'],
            ],
            $result
        );
    }

    public function testAddEmpty()
    {
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->add(['key3' => 'value3']);
        $this->assertSame(40, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
                ['key3' => 'value3'],
            ],
            $result
        );
    }

    public function testModify()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->modify(0, ['key3' => 'value3']);
        $this->assertSame(78, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
                ['key3' => 'value3'],
                ['key2' => 'value2'],
            ],
            $result
        );
    }

    public function testModifyEmpty()
    {
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->modify(0, ['key3' => 'value3']);
        $this->assertSame(0, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
            ],
            $result
        );
    }

    public function testRemove()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->remove(0);
        $this->assertSame(45, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
                1 => ['key2' => 'value2'],
            ],
            $result
        );
    }

    public function testRemoveEmpty()
    {
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->remove(0);
        //$this->assertSame(4, $result); can be 2. https://travis-ci.org/Raphhh/balloon/jobs/60049978
        $result = $fileManager->getAll();
        $this->assertSame(
            [
            ],
            $result
        );
    }

    public function testRemoveAll()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $jsonFileReader->write($data);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->removeAll();
        $this->assertSame(4, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
            ],
            $result
        );
    }

    public function testRemoveAllEmpty()
    {
        $fileReader = new DummyFileReader();
        $jsonFileReader = new Json($fileReader);
        $fileManager = new FileManager($jsonFileReader);
        $result = $fileManager->removeAll();
        $this->assertSame(4, $result);
        $result = $fileManager->getAll();
        $this->assertSame(
            [
            ],
            $result
        );
    }
}
