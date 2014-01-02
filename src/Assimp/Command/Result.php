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
 * @package   php-assimp
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace Assimp\Command;

use Assimp\Command\Verbs\Interfaces\VerbInterface;

/**
 * Assimp Command Result
 *
 * @author magdev
 */
final class Result
{
    /** @var \Assimp\Command\Verbs\VerbInterface */
    private $verb = null;

    /** @var array */
    private $output = array();

    /** @var int */
    private $exitCode = null;

    /** @var string */
    private $command = null;


    /**
     * Constructor
     *
     * @param \Assimp\Command\Verbs\VerbInterface $verb
     */
    public function __construct(VerbInterface $verb = null)
    {
        if (!is_null($verb)) {
            $this->setVerb($verb);
        }
    }


    /**
     * Set the exit-code
     *
     * @param int $exitCode
     * @return \Assimp\Command\Result
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = (int) $exitCode;
        return $this;
    }


    /**
     * Get the exit-code
     *
     * @return int
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }


    /**
     * Check if the command was successful executed
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return !is_null($this->exitCode) && $this->exitCode === 0;
    }


    /**
     * Get the executed command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }


    /**
     * Set the executed command
     *
     * @param string $command
     * @return \Assimp\Command\Result
     */
    public function setCommand($command)
    {
        $this->command = (string) $command;
        return $this;
    }

    /**
     * Get the verb
     *
     * @return \Assimp\Command\Verbs\VerbInterface
     */
    public function getVerb()
    {
        return $this->verb;
    }


    /**
     * Set the verb
     *
     * @param \Assimp\Command\Verbs\VerbInterface $verb
     * @return \Assimp\Command\Result
     */
    public function setVerb(VerbInterface $verb)
    {
        $this->verb = $verb;
        return $this;
    }


    /**
     * Get the full output array
     *
     * @param string|null $glue
     * @return string|array
     */
    public function getOutput($glue = null)
    {
        if (!is_null($glue)) {
            return implode($glue, $this->output);
        }
        return $this->output;
    }


    /**
     * Get a specific line from the output array
     *
     * @param int $line
     * @return string|null
     */
    public function getOutputLine($line)
    {
        return array_key_exists($line, $this->output) ? $this->output[$line] : null;
    }

    /**
     * Set the output array
     *
     * @param array $output
     * @return \Assimp\Command\Result
     */
    public function setOutput(array $output)
    {
        $this->output = $output;
        return $this;
    }
}