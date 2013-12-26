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
use Assimp\Command\CommandException;

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

    /** @var array */
    protected $arguments = array();

    /** @var array */
    protected $results = array();

    /** @var int */
    protected $exitCode = null;

    /** @var string */
    protected $executedCommand = null;

    /** @var \Assimp\Command\CommandException */
    protected $exception = null;


    /**
     * Constructor
     *
     * @param string $file
     * @param array $arguments
     */
    public function __construct($file = null, array $arguments = null)
    {
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
     */
    public function getCommand()
    {
    	if (!$this->getFile()) {
    		throw new \RuntimeException('Input-File is required', ErrorCodes::MISSING_VALUE);
    	}
        return rtrim($this->getName().' '.$this->getArguments(true).' '.$this->getFile());
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::setResults()
     */
    public function setResults(array $results)
    {
        $this->results = $this->parseResults($results);
        return $this;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::setExitCode()
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = (int) $exitCode;
        return $this;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getExitCode()
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getResults()
     */
    public function getResults()
    {
        if (sizeof($this->results)) {
            return $this->results;
        }
        return null;
    }


    /**
     * Check if the process finished successful
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return !is_null($this->exitCode) && $this->exitCode === 0;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::setException()
     */
    public function setException(CommandException $e)
    {
    	$this->exception = $e;

        $results = array(
            get_class($e).': '.$e->getMessage(),
            'in '.$e->getFile().':'.$e->getLine(),
        );
        $results += $e->getTrace();

        $this->setExitCode($e->getCode())
            ->setResults($results);
        return $this;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getException()
     */
    public function getException()
    {
    	return $this->exception;
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
            $args = '';
            foreach ($this->arguments as $arg => $value) {
                if (is_bool($value)) {
                    if ($value) {
                        $args .= strlen($arg) === 1 ? '-'.$arg : '--'.$arg;
                    }
                } else {
                    if ($value) {
                        $args .= strlen($arg) === 1 ? '-'.$arg.$value : '--'.$arg.'='.$value;
                    }
                }
            }
            return $args;
        }
        return $this->arguments;
    }


    /**
     * Set all arguments at once
     *
     * @param array $arguments
     * @return \Assimp\Command\Verbs\AbstractVerb
     */
    public function setArguments(array $arguments)
    {
        foreach ($arguments as $arg => $value) {
            $this->setArgument($arg, $value);
        }
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
        $this->arguments[$arg] = $value;
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
        return array_key_exists($arg, $this->arguments);
    }


    /**
     * Get an argument value
     *
     * @param string $arg
     * @return mixed
     */
    public function getArgument($arg)
    {
        if ($this->hasArgument($arg)) {
            return $this->arguments[$arg];
        }
        return null;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::getExecutedCommand()
     */
    public function getExecutedCommand()
    {
        return $this->executedCommand;
    }


    /**
     * @see \Assimp\Command\Verbs\VerbInterface::setExecutedCommand()
     */
    public function setExecutedCommand($executedCommand)
    {
        $this->executedCommand = (string) $executedCommand;
        return $this;
    }


    /**
     * Parse results if needed
     *
     * @param array $results
     * @return array
     */
    protected function parseResults(array $results)
    {
        return $results;
    }
}