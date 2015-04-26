<?php
namespace Balloon\Mapper;

use Balloon\Bridge\IFileReader;

/**
 * Class DataMapperDecorator
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DataMapperDecorator implements IFileReader
{
    /**
     * @var IFileReader
     */
    private $fileReader;

    /**
     * @var DataMapper
     */
    private $dataMapper;

    /**
     * @param IFileReader $fileReader
     * @param DataMapper $dataMapper
     */
    public function __construct(IFileReader $fileReader, DataMapper $dataMapper)
    {
        $this->fileReader = $fileReader;
        $this->dataMapper = $dataMapper;
    }

    /**
     * @return array
     */
    public function read()
    {
        return $this->dataMapper->tie((array)$this->fileReader->read());
    }

    /**
     * @param array $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        return $this->fileReader->write($this->dataMapper->untie((array)$data), $mode);
    }
}
