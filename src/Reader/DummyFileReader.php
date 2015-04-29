<?php
namespace Balloon\Reader;

/**
 * Class DummyFileReader
 * @package Balloon\Reader
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DummyFileReader implements IFileReader
{
    /**
     * @var string
     */
    private $content = '';

    /**
     * @return string
     */
    public function read()
    {
        return $this->content;
    }

    /**
     * @param string $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        if($mode & FILE_APPEND){
            $this->content .= $data;
        }else{
            $this->content = $data;
        }
        return strlen($data);
    }
}
