<?php
namespace Balloon\Manager\resources;

class Bar
{
    public $key1;

    public function __construct($key1)
    {
        $this->key1 = $key1;
    }

    public function getKey1()
    {
        return '_'.$this->key1;
    }
}
