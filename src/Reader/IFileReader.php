<?php
namespace Balloon\Reader;

/**
 * Interface IFormatReader
 * @package Balloon\Reader
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IFileReader
{
    /**
     * @return mixed
     */
    public function read();

    /**
     * @param mixed $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0);
}
