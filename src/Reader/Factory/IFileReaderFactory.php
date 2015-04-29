<?php
namespace Balloon\Reader\Factory;

use Balloon\Reader\IFileReader;

/**
 * Interface IFileReaderFactory
 * @package Balloon\Reader\Factory
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IFileReaderFactory
{
    /**
     * @param $filePath
     * @return IFileReader
     */
    public function create($filePath);
}
