<?php
namespace Balloon\Manager;

use Balloon\Reader\IFileReader;

/**
 * Class FileManager
 * @package Balloon\Manager
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileManager implements IFileManager
{
    /**
     * @var IFileReader
     */
    private $fileReader;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @param IFileReader $fileReader
     * @param string $primaryKey
     */
    public function __construct(IFileReader $fileReader, $primaryKey = '')
    {
        $this->setFileReader($fileReader);
        $this->setPrimaryKey($primaryKey);
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->getAll());
    }

    /**
     * @param mixed $id
     * @return mixed|null
     */
    public function get($id)
    {
        if($this->has($id)){
            return $this->getAll()[$id];
        }
        return null;
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function getList(array $ids)
    {
        $all = $this->getAll();
        $result = array_intersect_key((array)$all, $ids);
        if(is_object($all)){
            return new $all($result);
        }
        return $result;
    }

    /**
     * @param callable $filter
     * @return mixed
     */
    public function find(callable $filter = null)
    {
        $all = $this->getAll();
        $result = array_filter((array)$all, $filter);
        if(is_object($all)){
            return new $all($result);
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = $this->fileReader->read();
        if(is_null($result)){
            return [];
        }
        if(is_scalar($result)){
            return (array)$result;
        }
        return $result;
    }

    /**
     * @param mixed $data
     * @return int
     */
    public function add($data)
    {
        $dataList = $this->getAll();
        $key = $this->retrieveKey($data);
        if($key){
            $dataList[$key] = $data;
        }else{
            $dataList[] = $data;
        }
        return $this->fileReader->write($dataList);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    private function retrieveKey($data)
    {
        if($this->getPrimaryKey()){
            $pk = $this->getPrimaryKey();
            if(is_array($data)){
                if(array_key_exists($pk, $data)) {
                    return $data[$pk];
                }
            }elseif(is_object($data)){
                if(method_exists($data, 'get'.$pk)){
                    return $data->{'get'.$pk}();
                }
                if(property_exists($data, $pk)) {
                    return $data->{$pk};
                }
            }
        }
        return null;
    }

    /**
     * @param mixed $dataList
     * @return int
     */
    public function addList($dataList)
    {
        $result = 0;
        foreach($dataList as $data){
            $result = $this->add($data);
        }
        return $result;
    }

    /**
     * @param mixed $id
     * @param mixed $data
     * @return int
     */
    public function modify($id, $data)
    {
        $dataList = $this->getAll();
        if(isset($dataList[$id])){
            $dataList[$id] = $data;
            return $this->fileReader->write($dataList);
        }
        return 0;
    }

    /**
     * @param mixed $dataList
     * @return int
     */
    public function modifyList($dataList)
    {
        $result = 0;
        foreach($dataList as $id => $data){
            $result = $this->modify($id, $data);
        }
        return $result;
    }

    /**
     * @param mixed $id
     * @return int
     */
    public function remove($id)
    {
        $dataList = $this->getAll();
        unset($dataList[$id]);
        return $this->fileReader->write($dataList);
    }

    /**
     * @param array $ids
     * @return int
     */
    public function removeList(array $ids)
    {
        $result = 0;
        foreach($ids as $id){
            $result = $this->remove($id);
        }
        return $result;
    }

    /**
     * @return int
     */
    public function removeAll()
    {
        return $this->fileReader->write(null);
    }

    /**
     * Getter of $fileReader
     *
     * @return IFileReader
     */
    protected function getFileReader()
    {
        return $this->fileReader;
    }

    /**
     * Getter of $primaryKey
     *
     * @return string
     */
    protected function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Setter of $primaryKey
     *
     * @param string $primaryKey
     */
    private function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = (string)$primaryKey;
    }

    /**
     * Setter of $fileReader
     *
     * @param IFileReader $fileReader
     */
    private function setFileReader(IFileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }
}
