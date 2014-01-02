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

namespace Assimp\Tests\Command\Verbs;

use Assimp\Command\Verbs\ExportInfoVerb;

/**
 * Test for ExportInfoVerb
 *
 * @author magdev
 */
class ExportInfoVerbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Verbs\ExportInfoVerb
     */
    protected $object;


    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->object = new ExportInfoVerb();
    }


    /**
     * @covers Assimp\Command\Verbs\InfoVerb::getFormat
     * @covers Assimp\Command\Verbs\InfoVerb::setFormat
     * @covers Assimp\Command\Verbs\InfoVerb::getCacheKey
     */
    public function testGetSetFormat()
    {
        $this->object->setFormat('stl');
        $this->assertEquals('stl', $this->object->getFormat());
        $this->assertEquals('exportinfostl', $this->object->getCacheKey());
    }


    /**
     * @covers Assimp\Command\Verbs\ExportInfoVerb::parseResult
     */
    public function testResultParser()
    {
    	$testdata = array(
    		'stl',
    		'stl',
    		'Stereolithography',
    	);

		$this->object->getResult()->setOutput($testdata);
		$result = $this->object->getResult();

		$this->assertArrayHasKey('format', $result->getOutput());
		$this->assertArrayHasKey('extension', $result->getOutput());
		$this->assertArrayHasKey('name', $result->getOutput());
    }
}