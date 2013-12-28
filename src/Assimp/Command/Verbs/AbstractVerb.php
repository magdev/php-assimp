<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Marco Graetsch <magdev3.0@gmail.com>
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
 * @copyright 2013 Marco Graetsch <magdev3.0@gmail.com>
 * @package   php-assimp
 * @license   http://opensource.org/licenses/MIT MIT License
 */


namespace Assimp\Command\Verbs;

use Assimp\ErrorCodes;
use Assimp\Command\Result;
use Assimp\Command\CommandException;
use Assimp\Command\Verbs\Container\ParameterContainer;

/**
 * Abstract Verb-Class
 *
 * @author magdev
 */
abstract class AbstractVerb implements VerbInterface
{
    /** @var string */
    protected $name = null;

    /** @var string */
    protected $file = null;

    /** @var \Assimp\Command\Verbs\Container\ParameterContainer */
    protected $arguments = array();

    /** @var \Assimp\Command\Result */
    protected $result = array();


    /**
     * Constructor
     *
     * @param string $file
     * @param array $arguments
     */
    public function __construct($file = null, array $arguments = null)
    {
        $this->arguments = new ParameterContainer();

        if (is_string($file)) {
            $this->setFile($file);
        }
        if (is_array($arguments)) {
            $this->setArguments($arguments);
        }
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getName()
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::setFile()
     */
    public function setFile($file)
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException('File not found: '.$file, ErrorCodes::FILE_NOT_FOUND);
        }
        if (!is_readable($file)) {
            throw new \InvalidArgumentException('File is not readable: '.$file, ErrorCodes::FILE_NOT_READABLE);
        }
        $this->file = $file;
        return $this;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getFile()
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getCommand()
     * @refactor avoid multiple spaces if arguments empty
     */
    public function getCommand()
    {
        if ($this instanceof InputFileVerbInterface && !$this->getFile()) {
             throw new \RuntimeException('Input-File is required', ErrorCodes::MISSING_VALUE);
        }
        return rtrim($this->getName().' '.$this->getArguments(true).' '.$this->getFile());
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::setResult()
     */
    public function setResult(Result $result)
    {
        $this->result = $result;
        return $this;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getResult()
     */
    public function getResult()
    {
        if (!$this->result) {
            $this->result = new Result($this);
        }
        return $this->parseResult($this->result);
    }


    /**
     * Get the argument string
     *
     * @param boolean $asString
     * @return string|array
     */
    public function getArguments($asString = false)
    {
        if ($asString) {
            $str = (string) $this->arguments;
            return $str;
        }
        return $this->arguments->all();
    }


    /**
     * Set all arguments at once
     *
     * @param array $arguments
     * @return \Assimp\Command\Verbs\AbstractVerb
     */
    public function setArguments(array $arguments)
    {
        $this->arguments->set($arguments);
        return $this;
    }


    /**
     * Set an argument
     *
     * @param string $arg
     * @param mixed $value
     * @return \Assimp\Command\Verbs\AbstractVerb
     */
    public function setArgument($arg, $value)
    {
        $this->arguments->add($arg, $value);
        return $this;
    }


    /**
     * Check if an argument is set
     *
     * @param string $arg
     * @return boolean
     */
    public function hasArgument($arg)
    {
        return $this->arguments->has($arg);
    }


    /**
     * Get an argument value
     *
     * @param string $arg
     * @return mixed
     */
    public function getArgument($arg)
    {
        return $this->arguments->get($arg);
    }


    /**
     * Remove an argument
     *
     * @param string $arg
     * @return \Assimp\Command\Verbs\AbstractVerb
     */
    public function removeArgument($arg)
    {
        if ($this->hasArgument($arg)) {
            $this->arguments->remove($arg);
        }
        return $this;
    }


    /**
     * Get the argument container
     *
     * @return \Assimp\Command\Verbs\Container\ParameterContainer
     */
    public function getArgumentContainer()
    {
        return $this->arguments;
    }


    /**
     * Get the command
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getCommand();
        } catch (\RuntimeException $e) {
            return get_class($e).': '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine();
        }
    }


    /**
     * Parse result if needed
     *
     * @param \Assimp\Command\Result $results
     * @return \Assimp\Command\Result
     */
    protected function parseResult(Result $result)
    {
        return $result;
    }
}