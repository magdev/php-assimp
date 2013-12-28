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

namespace Assimp\Tests\Command\Verbs;

use Assimp\Command\Verbs\VersionVerb;

/**
 * Test for VersionVerb
 *
 * @author magdev
 */
class VersionVerbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Verbs\VersionVerb
     */
    protected $object;


    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new VersionVerb();
    }


    /**
     * @covers Assimp\Command\Verbs\VersionVerb::getCacheKey
     */
    public function testGetCacheKey()
    {
        $this->assertEquals('version', $this->object->getCacheKey());
    }


    /**
     * @covers Assimp\Command\Verbs\VersionVerb::parseResults
     */
    public function testResultParser()
    {
        $this->object->setResults(array('Version 3.0--shared -st  (SVNREV 1270)'));

        $results = $this->object->getResults();
        $this->assertCount(2, $results);
        $this->assertEquals('3.0', $results[0]);
        $this->assertEquals('1270', $results[1]);
    }

}