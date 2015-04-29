<?php
namespace Balloon\Proxy;

use Balloon\Reader\IFileReader;

/**
 * Class FileReaderCache
 * @package Balloon\Proxy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileReaderCache implements IFileReader
{
    /**
     * @var mixed
     */
    private $content;

    /**
     * @return mixed
     */
    public function read()
    {
        return $this->content;
    }

    /**
     * @param mixed $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        if(is_string($data) && $mode & FILE_APPEND){
            $this->content .= $data;
        }else{
            $this->content = $data;
        }
        return 0;
    }
}
