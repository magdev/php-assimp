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


/**
 * Interface for Assimp-Verbs
 *
 * @author magdev
 */
interface VerbInterface
{
    /**
     * Get the entire argument string
     *
     * @return string
     */
    public function getCommand();
    
    
    /**
     * Set the exit-code
     *
     * @param int $exitCode
     * @return \Assimp\Command\Verbs\VerbInterface
     */
    public function setExitCode($exitCode);
    
    
    /**
     * Get the exit-code
     *
     * @return int
     */
    public function getExitCode();
    
    
    /**
     * Set the results of the command
     *
     * @param array $results
     * @return \Assimp\Command\Verbs\VerbInterface
     */
    public function setResults(array $results);
    
    
    /**
     * Get the results
     *
     * @return array
     */
    public function getResults();
}