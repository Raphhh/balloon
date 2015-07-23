<?php
namespace Balloon\Mapper\resources;

use JMS\Serializer\Annotation\Type;

/**
 * Class Class1
 * @package Balloon\Mapper\resources
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Bar
{
    /**
     * @var string
     * @Type("string")
     */
    private $key1;

    /**
     * @var Foo
     * @Type("Balloon\Mapper\resources\Foo")
     */
    private $key2;

    /**
     * @param string $key1
     */
    public function __construct($key1 = '')
    {
        $this->key1 = $key1;
    }

    /**
     * @return string
     */
    public function getKey1()
    {
        return $this->key1;
    }

    /**
     * @param string $key1
     */
    public function setKey1($key1)
    {
        $this->key1 = (string) $key1;
    }

    /**
     * @return Foo
     */
    public function getKey2()
    {
        return $this->key2;
    }

    /**
     * @param Foo $key2
     */
    public function setKey2(Foo $key2)
    {
        $this->key2 = $key2;
    }
}
