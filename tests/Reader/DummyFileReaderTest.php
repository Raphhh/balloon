<?php
namespace Balloon\Reader;

/**
 * Class DummyFileReaderTest
 * @package Balloon\Reader
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DummyFileReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testWrite()
    {
        $dummyFileReader = new DummyFileReader();
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def'));
        $this->assertSame('def', $dummyFileReader->read());
    }

    public function testWriteAppend()
    {
        $dummyFileReader = new DummyFileReader();
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def', FILE_APPEND|LOCK_EX));
        $this->assertSame('abcdef', $dummyFileReader->read());
    }
}
