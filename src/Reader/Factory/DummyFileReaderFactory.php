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
     * @var IFileReader
     */
    private $fileReader;

    /**
     * @param IFileReader $fileReader
     */
    public function __construct(IFileReader $fileReader = null)
    {
        $this->fileReader = $fileReader ? : new DummyFileReader();
    }

    /**
     * @param string $filePath
     * @return IFileReader
     */
    public function create($filePath)
    {
        return $this->fileReader;
    }
}
