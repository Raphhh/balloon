<?php
namespace Balloon\Proxy;

/**
 * Class FileReaderProxyTest
 * @package Balloon\Proxy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileReaderProxyTest extends \PHPUnit_Framework_TestCase
{

    public function testRead()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->once())
            ->method('read');

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $proxy->read();
        $proxy->read();
    }

    public function testReadWithWrite()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->once())
            ->method('read')
            ->will($this->returnValue(''));

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $this->assertSame('', $proxy->read());
        $proxy->write('a');
        $this->assertSame('a', $proxy->read());
        $proxy->write('b');
        $this->assertSame('b', $proxy->read());
        $proxy->write('c', FILE_APPEND);
        $this->assertSame('bc', $proxy->read());
    }

    public function testReadWithInvalidate()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->exactly(2))
            ->method('read');

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $proxy->read();
        $proxy->invalidate();
        $proxy->read();
    }

    public function testWrite()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->never())
            ->method('write');

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $proxy->write('abc');
        $proxy->write('def');
    }

    public function testWriteWithFlush()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->once())
            ->method('write')
            ->with('abcdef');

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $proxy->write('abc');
        $proxy->write('def', FILE_APPEND);
        $proxy->flush();
    }

    public function testWriteWithInvalidate()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->once())
            ->method('write')
            ->with('');

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $proxy->write('abc');
        $proxy->write('def', FILE_APPEND);
        $proxy->invalidate();
        $proxy->flush();
    }

    public function testFlush()
    {
        $fileReader = $this->getMock('Balloon\Bridge\DummyFileReader');
        $fileReader->expects($this->at(0))
            ->method('write')
            ->with('abcdef');

        $fileReader->expects($this->at(1))
            ->method('write')
            ->with('abcdef');

        $cache = new FileReaderCache();
        $proxy = new FileReaderProxy($fileReader, $cache);
        $proxy->write('abc');
        $proxy->write('def', FILE_APPEND);
        $proxy->flush();
        $proxy->flush();
    }
}
