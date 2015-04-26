<?php
namespace Balloon\Mapper;

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
     * @param string $className
     */
    public function __construct($className = '')
    {
        $this->className = $className;
    }

    /**
     * @param array $dataList
     * @return \ArrayObject
     */
    public function tie(array $dataList)
    {
        if(!$this->className){
            return new \ArrayObject($dataList);
        }

        $result = new \ArrayObject();
        foreach($dataList as $key => $data){
            $object = $this->mapData($data);
            $result[$key] = $object;
        }
        return $result;
    }

    /**
     * @param mixed[] $objects
     * @return array
     */
    public function untie(array $objects)
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
     * @param array $data
     * @return mixed
     */
    private function mapData(array $data)
    {
        $object = new $this->className;
        foreach($data as $property => $value){
            $object->{'set'.$property}($value);
        }
        return $object;
    }
}
