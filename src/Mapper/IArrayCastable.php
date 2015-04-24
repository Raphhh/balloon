<?php
namespace Balloon\Mapper;

/**
 * Interface IArrayCastable
 * @package Balloon\Mapper
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IArrayCastable 
{
    /**
     * @return array
     */
    public function toArray();
}
