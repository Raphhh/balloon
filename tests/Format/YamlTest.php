<?php
namespace Balloon\Format;

use Balloon\Reader\DummyFileReader;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlTest
 * @package Balloon\Format
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class YamlTest extends \PHPUnit_Framework_TestCase
{

    public function testRead()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();
        $fileReader->write(json_encode($data));

        $yaml = new Yaml($fileReader, new Parser(), new Dumper());
        $result = $yaml->read();
        $this->assertSame($data, $result);
    }

    public function testWrite()
    {
        $data = [['key1' => 'value1'], ['key2' => 'value2']];
        $fileReader = new DummyFileReader();  ;

        $yaml = new Yaml($fileReader, new Parser(), new Dumper(), 2);
        $yaml->write($data);
        $this->assertSame(
            "-
    key1: value1
-
    key2: value2
",
            $fileReader->read()
        );
    }
}