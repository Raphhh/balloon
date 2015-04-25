<?php
namespace Balloon\Bridge\Factory;

use Balloon\Bridge\FileReader;
use Balloon\Bridge\IFileReader;

/**
 * Class FileReaderFactory
 * @package Balloon\Bridge\Factory
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileReaderFactory implements IFileReaderBridgeFactory
{
    /**
     * @var bool
     */
    private $useIncludePath;

    /**
     * @var resource
     */
    private $context;

    /**
     * @param bool $useIncludePath
     * @param resource $context
     */
    public function __construct($useIncludePath = false, $context = null)
    {
        $this->useIncludePath = $useIncludePath;
        $this->context = $context;
    }

    /**
     * @param $filePath
     * @return IFileReader
     */
    public function create($filePath)
    {
        return new FileReader($filePath, $this->useIncludePath, $this->context);
    }
}
