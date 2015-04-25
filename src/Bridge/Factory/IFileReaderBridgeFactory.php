<?php
namespace Balloon\Bridge\Factory;

use Balloon\Bridge\IFileReader;

/**
 * Interface IFileReaderBridgeFactory
 * @package Balloon\Bridge\Factory
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
