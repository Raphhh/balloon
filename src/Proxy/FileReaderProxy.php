<?php
namespace Balloon\Proxy;

use Balloon\Bridge\IFileReader;

/**
 * Class FileReaderProxy
 * @package Balloon\Proxy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileReaderProxy implements IFileReader, IProxy
{
    /**
     * @var IFileReader
     */
    private $fileReader;

    /**
     * @var FileReaderCache
     */
    private $cache;

    /**
     * @var bool
     */
    private $isCached = false;

    /**
     * @param IFileReader $fileReader
     * @param FileReaderCache $cache
     */
    public function __construct(IFileReader $fileReader, FileReaderCache $cache)
    {
        $this->fileReader = $fileReader;
        $this->cache = $cache;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        if(!$this->isCached){
            $this->cache->write($this->fileReader->read());
            $this->isCached = true;
        }
        return $this->cache->read();
    }

    /**
     * @param mixed $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        return $this->cache->write($data, $mode);
    }

    /**
     * @return int
     */
    public function flush()
    {
        return $this->fileReader->write($this->cache->read());
    }

    /**
     *
     */
    public function clear()
    {
        $this->invalidate();
        $this->read();
    }

    /**
     * @return int
     */
    public function invalidate()
    {
        $this->isCached = false;
        return $this->cache->write(null);
    }
}
