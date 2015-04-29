<?php
namespace Balloon\Reader;

use Gaufrette\Filesystem;

/**
 * Class GaufretteAdapter
 * @package Balloon\Reader
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class GaufretteAdapter implements IFileReader
{

    /**
     * @var Filesystem
     */
    private $gaufrette;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @param Filesystem $gaufrette
     * @param string $filePath
     */
    public function __construct(Filesystem $gaufrette, $filePath)
    {
        $this->gaufrette = $gaufrette;
        $this->filePath = $filePath;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        if(!$this->gaufrette->has($this->filePath)){
            return '';
        }
        return $this->gaufrette->read($this->filePath);
    }

    /**
     * @param mixed $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        if($mode & FILE_APPEND){
            $data = $this->read() . $data;
        }
        if(!$this->gaufrette->has($this->filePath)){
            $this->gaufrette->createFile($this->filePath);
        }
        return $this->gaufrette->write($this->filePath, $data, true);
    }
}
