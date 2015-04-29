<?php
namespace Balloon\Decorator;

use Balloon\Reader\IFileReader;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Class Yaml
 * @package Balloon\Decorator
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Yaml implements IFileReader
{
    /**
     * @var IFileReader
     */
    private $fileReader;

    /**
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var Dumper
     */
    private $yamlDumper;
    /**
     * @var
     */
    private $dumpLevel;

    /**
     * @param IFileReader $fileReader
     * @param Parser $yamlParser
     * @param Dumper $yamlDumper
     * @param $dumpLevel
     */
    public function __construct(IFileReader $fileReader, Parser $yamlParser, Dumper $yamlDumper, $dumpLevel = 0)
    {
        $this->fileReader = $fileReader;
        $this->yamlParser = $yamlParser;
        $this->yamlDumper = $yamlDumper;
        $this->dumpLevel = $dumpLevel;
    }

    /**
     * @return array|null
     */
    public function read()
    {
        return $this->yamlParser->parse($this->fileReader->read());
    }

    /**
     * @param mixed $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        return $this->fileReader->write($this->yamlDumper->dump($data, $this->dumpLevel), $mode);
    }
}
