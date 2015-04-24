<?php
namespace Balloon\Bridge;

/**
 * Class FileReaderTest
 * @package Balloon\Bridge
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testWrite()
    {
        $filePath = __DIR__ . '/resources/file.txt';
        file_put_contents($filePath, '');
        $dummyFileReader = new FileReader($filePath);
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def'));
        $this->assertSame('def', $dummyFileReader->read());
        file_put_contents($filePath, '');
    }

    public function testWriteAppend()
    {
        $filePath = __DIR__ . '/resources/file.txt';
        file_put_contents($filePath, '');
        $dummyFileReader = new FileReader($filePath);
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def', FILE_APPEND|LOCK_EX));
        $this->assertSame('abcdef', $dummyFileReader->read());
        file_put_contents($filePath, '');
    }

    public function testWriteInNotExistingFile()
    {
        $filePath = __DIR__ . '/resources/none.txt';
        $dummyFileReader = new FileReader($filePath);
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def'));
        $this->assertSame('def', $dummyFileReader->read());
        unlink($filePath);
    }
}
