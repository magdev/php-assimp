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
 * @package
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace Assimp\Command\Result\Interfaces;

use Assimp\Command\Verbs\Interfaces\VerbInterface;

interface ResultInterface
{
    /**
     * Constructor
     *
     * @param \Assimp\Command\Verbs\Interfaces\VerbInterface $verb
     */
	public function __construct(VerbInterface $verb = null);


    /**
     * Check if the verb has been executed
     *
     * @return boolean
     */
    public function isExecuted(): bool;


    /**
     * Check if the command was successful executed
     *
     * @return boolean
     */
    public function isSuccess(): bool;


    /**
     * Set the exit-code
     *
     * @param int $exitCode
     * @return \Assimp\Command\Result\Interfaces\ResultInterface
     */
    public function setExitCode(int $exitCode): ResultInterface;


    /**
     * Get the exit-code
     *
     * @return int
     */
    public function getExitCode(): int;


    /**
     * Get the executed command
     *
     * @return string
     */
    public function getCommand(): string;


    /**
     * Set the executed command
     *
     * @param string $command
     * @return \Assimp\Command\Result\Interfaces\ResultInterface
     */
    public function setCommand(string $command): ResultInterface;


    /**
     * Get the verb
     *
     * @return \Assimp\Command\Verbs\Interfaces\VerbInterface
     */
    public function getVerb(): VerbInterface;


    /**
     * Set the verb
     *
     * @param \Assimp\Command\Verbs\Interfaces\VerbInterface $verb
     * @return \Assimp\Command\Result\Interfaces\ResultInterface
     */
    public function setVerb(VerbInterface $verb): ResultInterface;


    /**
     * Get the full output array
     *
     * @param string|null $glue
     * @return string|array
     */
    public function getOutput(sting $glue = null);


    /**
     * Set the output array
     *
     * @param array $output
     * @return \Assimp\Command\Result\Interfaces\ResultInterface
     */
    public function setOutput(array $output): ResultInterface;


    /**
     * Get a specific line from the output array
     *
     * @param int|string $line
     * @return string|null
     */
    public function getOutputLine(int $line): string;
}