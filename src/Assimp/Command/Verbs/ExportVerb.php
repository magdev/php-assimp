<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Marco Graetsch <magdev3.0@googlemail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    magdev
 * @copyright 2013 Marco Graetsch <magdev3.0@googlemail.com>
 * @package
 * @license   http://opensource.org/licenses/MIT MIT License
 */


namespace Assimp\Command\Verbs;

use Assimp\ErrorCodes;

/**
 * Assimp Export Verb
 *
 * @author magdev
 */
class ExportVerb extends AbstractVerb
{
    /** @var string */
    protected $name = 'export';

    /** @var string */
    protected $outputFile = null;

    /** @var array */
    protected $parameters = array();



    /**
     * Set the output format
     *
     * @param string $format
     * @return \Assimp\Command\Verbs\ExportVerb
     */
    public function setFormat($format)
    {
        $this->setArgument('format', $format);
        return $this;
    }


    /**
     * Get the output format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->getArgument('format');
    }


    /**
     * Set the output file
     *
     * @param string $file
     * @return \Assimp\Command\Verbs\ExportVerb
     */
    public function setOutputFile($file)
    {
    $dir = dirname($file);
    if (is_file($file)) {
            throw new \InvalidArgumentException('File exists: '.$file, ErrorCodes::FILE_EXISTS);
        }
        if (!is_dir($dir)) {
        throw new \InvalidArgumentException('Directory not exists: '.$dir, ErrorCodes::DIR_NOT_FOUND);
        }
        if (!is_writable($dir)) {
        throw new \InvalidArgumentException('Directory not writeable: '.$dir, ErrorCodes::DIR_NOT_WRITEABLE);
        }
        $this->outputFile = $file;
        return $this;
    }


    /**
     * Get the output file
     *
     * @return string
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }


    /**
     * Set multiple parameters
     *
     * @param array $params
     * @return \Assimp\Command\Verbs\ExportVerb
     */
    public function setParameters(array $params)
    {
        foreach ($params as $name => $value) {
            $this->setParameter($name, $value);
        }
        return $this;
    }


    /**
     * Get all parameters
     *
     * @param boolean $asString
     * @return string|array
     */
    public function getParameters($asString = false)
    {
        if ($asString) {
            $params = '';
            foreach ($this->parameters as $name => $value) {
                $params .= '--'.$name.'='.$value;
            }
            return $params;
        }
        return $this->parameters;
    }


    /**
     * Set a specific parameter
     *
     * @param string $name
     * @param mixed $value
     * @return \Assimp\Command\Verbs\ExportVerb
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }


    /**
     * Get a specific parameter
     *
     * @param string $name
     * @return mixed
     */
    public function getParameter($name)
    {
        if ($this->hasParameter($name)) {
            return $this->parameters[$name];
        }
        return null;
    }


    /**
     * Check if a specific parameter is set
     *
     * @param string $name
     * @return boolean
     */
    public function hasParameter($name)
    {
        return array_key_exists($name, $this->parameters);
    }


    /**
     * @see \Assimp\Command\Verbs\AbstractVerb::getCommand()
     */
    public function getCommand()
    {
    if (!$this->getFile()) {
    throw new \RuntimeException('Input-File is required', ErrorCodes::MISSING_VALUE);
    }
    if (!$this->getOutputFile()) {
    throw new \RuntimeException('Input-File is required', ErrorCodes::MISSING_VALUE);
    }
        return rtrim($this->getName().' '.$this->getFile().' '.$this->getOutputFile().' '.$this->getArguments(true).' '.$this->getParameters(true));
    }
}