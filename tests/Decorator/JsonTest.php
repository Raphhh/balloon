<?php
namespace Balloon\Decorator;

use Balloon\Bridge\DummyFileReader;

/**
 * Class JsonTest
 * @package Balloon\Decorator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class JsonTest extends \PHPUnit_Framework_TestCase
{

    public function testRead()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $fileReader->write(json_encode($data));

        $json = new Json($fileReader);
        $result = $json->read();
        $this->assertSame($data, $result);
    }

    public function testWrite()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();  ;

        $json = new Json($fileReader);
        $json->write($data);
        $this->assertSame(
'[
    {
        "key1": "value1"
    },
    {
        "key2": "value2"
    }
]',
            $fileReader->read()
        );
    }
}
