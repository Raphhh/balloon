<?php
namespace Balloon;

use Balloon\Manager\FileManager;
use Balloon\Proxy\FileReaderProxy;
use Balloon\Proxy\IProxy;

/**
 * Class Balloon
 * @package Balloon
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @method FileReaderProxy getFileReader()
 */
class Balloon extends FileManager implements IProxy
{
    /**
     * @param FileReaderProxy $fileReaderProxy
     * @param string $primaryKey
     */
    public function __construct(FileReaderProxy $fileReaderProxy, $primaryKey = '')
    {
        parent::__construct($fileReaderProxy, $primaryKey);
    }

    /**
     * writes the modification into the file.
     *
     * @return int
     */
    public function flush()
    {
        return $this->getFileReader()->flush();
    }

    /**
     * rollbacks the modifications not pushed.
     */
    public function clear()
    {
        $this->getFileReader()->clear();
    }

    /**
     * invalidates the cache of the file.
     *
     * @return int
     */
    public function invalidate()
    {
        return $this->getFileReader()->invalidate();
    }
}
