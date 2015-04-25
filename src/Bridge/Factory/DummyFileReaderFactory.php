<?php
namespace Balloon\Bridge\Factory;

use Balloon\Bridge\DummyFileReader;
use Balloon\Bridge\IFileReader;

/**
 * Class DummyFileReaderFactory
 * @package Balloon\Bridge\Factory
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DummyFileReaderFactory implements IFileReaderBridgeFactory
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
