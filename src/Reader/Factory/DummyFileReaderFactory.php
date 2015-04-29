<?php
namespace Balloon\Reader\Factory;

use Balloon\Reader\DummyFileReader;
use Balloon\Reader\IFileReader;

/**
 * Class DummyFileReaderFactory
 * @package Balloon\Reader\Factory
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DummyFileReaderFactory implements IFileReaderFactory
{
    /**
     * @param $filePath
     * @return IFileReader
     */
    public function create($filePath)
    {
        return new DummyFileReader();
    }
}
