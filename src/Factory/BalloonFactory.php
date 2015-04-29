<?php
namespace Balloon\Factory;

use Balloon\Balloon;
use Balloon\Reader\Factory\FileReaderFactory;
use Balloon\Reader\Factory\IFileReaderFactory;
use Balloon\Reader\IFileReader;
use Balloon\Decorator\Json;
use Balloon\Decorator\Yaml;
use Balloon\Mapper\DataMapper;
use Balloon\Mapper\DataMapperDecorator;
use Balloon\Proxy\FileReaderCache;
use Balloon\Proxy\FileReaderProxy;
use ICanBoogie\Inflector;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Class BalloonFactory
 * @package Balloon\Factory
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class BalloonFactory
{
    /**
     * @var IFileReaderFactory
     */
    private $fileReaderBridgeFactory;

    /**
     * @param IFileReaderFactory $fileReaderBridgeFactory
     */
    public function __construct(IFileReaderFactory $fileReaderBridgeFactory = null)
    {
        $this->fileReaderBridgeFactory = $fileReaderBridgeFactory ? : new FileReaderFactory();
    }

    /**
     * @param string $filePath
     * @param string $className
     * @param string $primaryKey
     * @return Balloon
     */
    public function create($filePath, $className = '', $primaryKey = '')
    {
        $format = pathinfo($filePath, PATHINFO_EXTENSION);
        if(!method_exists($this, $format)){
            throw new \InvalidArgumentException(sprintf('Format %s not supported', $format));
        }

        return $this->$format($filePath, $className, $primaryKey);
    }

    /**
     * @param string $filePath
     * @param string $className
     * @param string $primaryKey
     * @param int $flags
     * @return Balloon
     */
    public function json($filePath, $className = '', $primaryKey = '', $flags = null)
    {
        return $this->instantiate(
            new Json($this->fileReaderBridgeFactory->create($filePath), $flags),
            $className,
            $primaryKey
        );
    }

    /**
     * @param string $filePath
     * @param string $className
     * @param string $primaryKey
     * @param int $dumpLevel
     * @return Balloon
     */
    public function yml($filePath, $className = '', $primaryKey = '', $dumpLevel = 0)
    {
        return $this->instantiate(
            new Yaml(
                $this->fileReaderBridgeFactory->create($filePath),
                new Parser(),
                new Dumper(),
                $dumpLevel
            ),
            $className,
            $primaryKey
        );
    }

    /**
     * @param IFileReader $formatDecorator
     * @param string $className
     * @param string $primaryKey
     * @return Balloon
     */
    private function instantiate(IFileReader $formatDecorator, $className, $primaryKey)
    {
        return new Balloon(
            new FileReaderProxy(
                new DataMapperDecorator(
                    $formatDecorator,
                    new DataMapper(
                        Inflector::get(),
                        $className
                    )
                ),
                new FileReaderCache()
            ),
            $primaryKey
        );
    }
}
