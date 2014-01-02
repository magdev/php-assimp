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

use Assimp\Command\Result;

/**
 * Assimp Version Verb
 *
 * @author magdev
 */
class VersionVerb extends AbstractVerb implements Interfaces\CacheableInterface
{
    /** @var string */
    protected $name = 'version';


    /**
     * @see \Assimp\Command\Verbs\AbstractVerb::parseResult()
     */
    protected function parseResult(Result $result)
    {
        foreach ($result->getOutput() as $row) {
            $matches = array();
            if (preg_match('/Version ([\d.]+).*\(SVNREV ([\d]+)\)/', $row, $matches)) {
                $result->setOutput(array(
                	'version' => $matches[1],
                	'svnrev' => $matches[2]
                ));
                continue;
            } else if (preg_match('/Version ([\d.]+).*/', $row, $matches)) {
                $result->setOutput(array(
                	'version' => $matches[1],
                ));
                continue;
            }
        }
        return $this;
    }


    /**
     * @see \Assimp\Command\Verbs\CacheableVerbInterface::getCacheKey()
     */
    public function getCacheKey()
    {
        return $this->getName();
    }
}