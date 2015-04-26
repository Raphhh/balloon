<?php
namespace Balloon\Bridge;

use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;

/**
 * Class GaufretteAdapterTest
 * @package Balloon\Bridge
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class GaufretteAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testWrite()
    {
        $filePath = '/resources/file.txt';
        file_put_contents(__DIR__ . $filePath, '');
        $dummyFileReader = new GaufretteAdapter($this->getGaufrette(), $filePath);
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def'));
        $this->assertSame('def', $dummyFileReader->read());
        file_put_contents(__DIR__ . $filePath, '');
    }

    public function testWriteAppend()
    {
        $filePath = '/resources/file.txt';
        file_put_contents(__DIR__ . $filePath, '');
        $dummyFileReader = new GaufretteAdapter($this->getGaufrette(), $filePath);
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(6, $dummyFileReader->write('def', FILE_APPEND|LOCK_EX));
        $this->assertSame('abcdef', $dummyFileReader->read());
        file_put_contents(__DIR__ . $filePath, '');
    }

    public function testWriteInNotExistingFile()
    {
        $filePath = '/resources/none.txt';
        $dummyFileReader = new GaufretteAdapter($this->getGaufrette(), $filePath);
        $this->assertSame('', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('abc'));
        $this->assertSame('abc', $dummyFileReader->read());
        $this->assertSame(3, $dummyFileReader->write('def'));
        $this->assertSame('def', $dummyFileReader->read());
        unlink(__DIR__ . $filePath);
    }

    /**
     * @return Filesystem
     */
    private function getGaufrette()
    {
        return new Filesystem(new Local(__DIR__));
    }
}
