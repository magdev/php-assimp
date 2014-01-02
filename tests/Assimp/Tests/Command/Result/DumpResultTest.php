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

namespace Assimp\Tests\Command\Result;

use Assimp\Command\Result\DumpResult;

/**
 * Test for Assimp DumpResult
 *
 * @author magdev
 */
class DumpResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Result\DumpResult
     */
    protected $object;

    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->object = new DumpResult();
    }


    /**
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
    	$this->object = null;
    }


    /**
     * @covers \Assimp\Command\Result\DumpResult::parse
     */
    public function testParse()
    {
    	$testdata = array(
            'Launching asset import ...           OK',
            'Validating postprocessing flags ...  OK',
            'Importing file ...                   OK',
            '   import took approx. 0.11398 seconds',
            '',
            'assimp dump: Wrote output dump Fuss2.assbin',
        );

        $result = $this->object->setOutput($testdata);

        $this->assertArrayHasKey('launching_asset_import', $this->object->getOutput());
        $this->assertArrayHasKey('importing_file', $this->object->getOutput());
        $this->assertArrayHasKey('import_time', $this->object->getOutput());
    }
}