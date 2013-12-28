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

use Assimp\Command\Verbs\KnowExtensionVerb;

/**
 * Test for KnownExtensionVerb
 *
 * @author magdev
 */
class KnowExtensionVerbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Verbs\KnownExtensionVerb
     */
    protected $object;


    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new KnowExtensionVerb();
    }


    /**
     * @covers Assimp\Command\Verbs\KnowExtensionVerb::getFormat
     * @covers Assimp\Command\Verbs\KnowExtensionVerb::setFormat
     */
    public function testGetSetFormat()
    {
        $this->object->setFormat('stl');
        $this->assertEquals('stl', $this->object->getFormat());
    }


    /**
     * @covers Assimp\Command\Verbs\KnowExtensionVerb::getCommand
     */
    public function testGetCommandSuccess()
    {
        $this->object->setFormat('stl');
        $this->assertEquals('knowext stl', $this->object->getCommand());
    }


    /**
     * @covers Assimp\Command\Verbs\KnowExtensionVerb::getCommand
     * @expectedException \RuntimeException
     */
    public function testGetCommandFailure()
    {
        $this->object->getCommand();
    }


    /**
     * @covers Assimp\Command\Verbs\KnowExtensionVerb::parseResults
     */
    public function testResultParser()
    {
        $this->object->setResults(array('known'));
        $results = $this->object->getResults();
        $this->assertTrue($results[0]);

        $this->object->setResults(array('not known'));
        $results = $this->object->getResults();
        $this->assertFalse($results[0]);
    }
}