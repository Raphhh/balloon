<?php
namespace Balloon\Bridge;

/**
 * Class FileReader
 * @package Balloon\Bridge
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FileReader implements IFileReader
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var bool
     */
    private $useIncludePath;

    /**
     * @var resource
     */
    private $context;

    /**
     * @var bool
     */
    private $exists = false;

    /**
     * @param string $filePath
     * @param bool $useIncludePath
     * @param resource $context
     */
    public function __construct($filePath, $useIncludePath = false, $context = null)
    {
        $this->setFilePath($filePath);
        $this->setUseIncludePath($useIncludePath);
        $this->setContext($context);
    }

    /**
     * @return string
     */
    public function read()
    {
        if(!$this->isExistingFile()){
            return '';
        }
        return file_get_contents($this->getFilePath(), $this->useIncludePath(), $this->getContext());
    }

    /**
     * @param string $data
     * @param int $mode
     * @return int
     */
    public function write($data, $mode = 0)
    {
        $this->createDir();
        return file_put_contents($this->getFilePath(), $data, $mode, $this->getContext());
    }

    /**
     * @return bool
     */
    public function isExistingFile()
    {
        if (!$this->exists) {
            $this->exists = file_exists($this->getFilePath());
        }
        return $this->exists;
    }

    /**
     * @return bool
     */
    public function isExistingDir()
    {
        if (!$this->exists) {
            $this->exists = is_dir($this->getDir());
        }
        return $this->exists;
    }

    /**
     * Getter of $filePath
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return dirname($this->getFilePath());
    }

    /**
     * Getter of $useIncludePath
     *
     * @return boolean
     */
    public function useIncludePath()
    {
        return $this->useIncludePath;
    }

    /**
     * Getter of $context
     *
     * @return resource
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Setter of $filePath
     *
     * @param string $filePath
     */
    private function setFilePath($filePath)
    {
        $this->filePath = (string)$filePath;
    }

    /**
     * Setter of $useIncludePath
     *
     * @param boolean $useIncludePath
     */
    private function setUseIncludePath($useIncludePath)
    {
        $this->useIncludePath = (boolean)$useIncludePath;
    }

    /**
     * Setter of $context
     *
     * @param resource $context
     */
    private function setContext($context)
    {
        $this->context = $context;
    }

    /**
     *
     */
    private function createDir()
    {
        if (!$this->isExistingDir()) {
            mkdir($this->getDir(), 0777, true);
            $this->exists = true;
        }
    }
}

