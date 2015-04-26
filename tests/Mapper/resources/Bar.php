<?php
namespace Balloon\Mapper\resources;

/**
 * Class Class1
 * @package Balloon\Mapper\resources
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Bar
{
    /**
     * @var string
     */
    public $key1;

    /**
     * @param string $key1
     */
    public function __construct($key1 = '')
    {
        $this->setKey1($key1);
    }

    /**
     * Getter of $key1
     *
     * @return string
     */
    public function getKey1()
    {
        return $this->key1;
    }

    /**
     * Setter of $key1
     *
     * @param string $key1
     */
    public function setKey1($key1)
    {
        $this->key1 = (string)$key1;
    }
}