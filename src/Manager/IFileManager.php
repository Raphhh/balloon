<?php
namespace Balloon\Manager;

/**
 * Interface IFileManager
 * @package Balloon\Manager
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IFileManager
{
    /**
     * @param mixed $id
     * @return bool
     */
    public function has($id);

    /**
     * @param mixed $id
     * @return mixed|null
     */
    public function get($id);

    /**
     * @return mixed[]
     */
    public function getAll();

    /**
     * @param mixed $data
     * @return int
     */
    public function add($data);

    /**
     * @param mixed $id
     * @param mixed $data
     * @return int
     */
    public function modify($id, $data);

    /**
     * @param mixed $id
     * @return int
     */
    public function remove($id);

    /**
     * @return int
     */
    public function removeAll();
}
