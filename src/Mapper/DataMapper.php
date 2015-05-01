<?php
namespace Balloon\Mapper;

use ICanBoogie\Inflector;

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
     * @param Inflector $inflector
     * @param string $className
     */
    public function __construct(Inflector $inflector, $className = '')
    {
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
            $object = $this->mapData($data);
            $result[$key] = $object;
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
            if($object instanceof IArrayCastable){
                $result[$key] = $object->toArray();
            }else{
                $result[$key] = (array)$object;
            }
        }
        return $result;
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
     * @return mixed
     */
    private function mapData(array $data)
    {
        $object = new $this->className;
        foreach($data as $property => $value){
            $method = 'set'.$property;
            if(method_exists($object, $method)){
                $object->$method($value);
            }else{
                $object->$property = $value;
            }
        }
        return $object;
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
        return new \ArrayObject($data);
    }
}
