<?php
namespace Balloon\Decorator;

use Balloon\Reader\IFileReader;

/**
 * Class Json
 * @package Balloon\Decorator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Json implements IFileReader
{
    /**
     * @var IFileReader
     */
    private $fileReader;

    /**
     * @var int
     */
    private $flags;

    /**
     * @param IFileReader $fileReader
     * @param int $flags
     */
    public function __construct(IFileReader $fileReader, $flags = null)
    {
        $this->fileReader = $fileReader;
        $this->initFlags($flags);
    }

    /**
     * @return array|null
     */
    public function read()
    {
        return json_decode($this->fileReader->read(), true);
    }

    /**
     * @param mixed $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        return $this->fileReader->write(json_encode($data, $this->flags), $mode);
    }

    /**
     * @param $flags
     */
    private function initFlags($flags)
    {
        if ($flags === null) {
            $this->flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        } else {
            $this->flags = $flags;
        }
    }
}
