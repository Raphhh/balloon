<?php
namespace Balloon\Reader\Factory;

use Balloon\Reader\IFileReader;

/**
 * Interface IFileReaderBridgeFactory
 * @package Balloon\Reader\Factory
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IFileReaderBridgeFactory
{
    /**
     * @param $filePath
     * @return IFileReader
     */
    public function create($filePath);
}
