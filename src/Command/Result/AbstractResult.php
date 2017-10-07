<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Marco Graetsch <magdev3.0@googlemail.com>
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
 * @copyright 2014 Marco Graetsch <magdev3.0@googlemail.com>
 * @package   php-assimp
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace Assimp\Command\Result;

use Assimp\Command\Verbs\Interfaces\VerbInterface;
use Assimp\Command\Result\Interfaces\ResultInterface;

/**
 * Abstract class for results
 *
 * @author magdev
 */
abstract class AbstractResult implements \ArrayAccess, \Countable, ResultInterface
{
    /** @var \Assimp\Command\Verbs\VerbInterface */
    protected $verb = null;

    /** @var array */
    protected $output = array();

    /** @var int */
    protected $exitCode = null;

    /** @var string */
    protected $command = null;

    /** @var boolean */
    protected $parsed = false;


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::__constructor()
     */
    public function __construct(VerbInterface $verb = null)
    {
        if (!is_null($verb)) {
            $this->setVerb($verb);
        }
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::isExecuted()
     */
    public function isExecuted()
    {
        return $this->getExitCode() !== null && $this->count();
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::isSuccess()
     */
    public function isSuccess()
    {
        return !is_null($this->exitCode) && $this->exitCode === 0;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::setExitCode()
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = (int) $exitCode;
        return $this;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::getExitCode()
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::getCommand()
     */
    public function getCommand()
    {
        return $this->command;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::setCommand()
     */
    public function setCommand($command)
    {
        $this->command = (string) $command;
        return $this;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::getVerb()
     */
    public function getVerb()
    {
        return $this->verb;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::setVerb()
     */
    public function setVerb(VerbInterface $verb)
    {
        $this->verb = $verb;
        return $this;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::getOutput()
     */
    public function getOutput($glue = null)
    {
        if (!is_null($glue)) {
            return implode($glue, $this->output);
        }
        return $this->output;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::setOutput()
     */
    public function setOutput(array $output)
    {
        $this->output = $output;
        $this->parse();
        return $this;
    }


    /**
     * @see \Assimp\Command\Result\Interfaces\ResultInterface::getOutputLine()
     */
    public function getOutputLine($line)
    {
        return array_key_exists($line, $this->output) ? $this->output[$line] : null;
    }


    /**
     * @see \ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return isset($this->output[$offset]);
    }


    /**
     * @see \ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return isset($this->output[$offset]) ? $this->output[$offset] : null;
    }


    /**
     * @see \ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->output[] = $value;
        } else {
            $this->output[$offset] = $value;
        }
    }


    /**
     * @see \ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        unset($this->output[$offset]);
    }


    /**
     * @see \Countable::count()
     */
    public function count()
    {
        return sizeof($this->output);
    }


    /**
     * Check if the output has been parsed
     *
     * @return boolean
     */
    protected function isParsed()
    {
    	return $this->parsed;
    }


    /**
     * Parse the output
     *
     * @return \Assimp\Command\Result
     */
    abstract protected function parse();
}
