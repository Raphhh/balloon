<?php
namespace Balloon\Mapper;

use ICanBoogie\Inflector;
use JMS\Serializer\Serializer;

/**
 * Class DataMapper
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DataMapper 
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var Inflector
     */
    private $inflector;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Serializer $serializer
     * @param Inflector $inflector
     * @param string $className
     */
    public function __construct(Serializer $serializer, Inflector $inflector, $className = '')
    {
        $this->serializer = $serializer;
        $this->inflector = $inflector;
        $this->setClassName($className);
    }

    /**
     * @param array $dataList
     * @return \ArrayObject
     */
    public function mapDataList(array $dataList)
    {
        if(!$this->getClassName()){
            return $this->instantiateCollection($dataList);
        }

        $result = [];
        foreach($dataList as $key => $data){
            $result[$key] = $this->mapData($data);
        }
        return $this->instantiateCollection($result);
    }

    /**
     * @param mixed[] $objects
     * @return array
     */
    public function unmapObjects(array $objects)
    {
        $result = [];
        foreach($objects as $key => $object){
            $result[$key] = $this->unmapObject($object);
        }
        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function mapData(array $data)
    {
        if(!$this->getClassName()){
            return $data;
        }
        return $this->serializer->fromArray($data, $this->getClassName());
    }


    /**
     * @param mixed $object
     * @return array
     */
    public function unmapObject($object)
    {
        if(is_array($object)){
            return $object;
        }
        return $this->serializer->toArray($object);
    }

    /**
     * Getter of $className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Setter of $className
     *
     * @param string $className
     */
    private function setClassName($className)
    {
        $this->className = (string)$className;
    }

    /**
     * @param array $data
     * @return \ArrayObject
     */
    private function instantiateCollection(array $data)
    {
        $collectionClassName = $this->inflector->pluralize($this->className);
        if(class_exists($collectionClassName)){
            return new $collectionClassName($data);
        }
        return $data;
    }
}
