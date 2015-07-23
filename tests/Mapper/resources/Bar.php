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
    public $key1;

    /**
     * @param string $key1
     */
    public function __construct($key1 = '')
    {
        $this->key1 = $key1;
    }
}
