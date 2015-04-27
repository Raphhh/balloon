<?php
namespace Balloon\Proxy;

/**
 * Interface IProxy
 * @package Balloon\Proxy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
interface IProxy
{
    /**
     * @return int
     */
    public function flush();

    /**
     * @return void
     */
    public function clear();

    /**
     * @return int
     */
    public function invalidate();
}
