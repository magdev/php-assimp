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

use Assimp\Command\Result\InfoResult;

/**
 * Test for Assimp InfoResult
 *
 * @author magdev
 */
class InfoResultTest extends \PHPUnit_Framework_TestCase
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
        $this->object = new InfoResult();
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
            'Memory consumption: 1518080 B',
            'Nodes:              1',
            'Maximum depth       1',
            'Meshes:             1',
            'Animations:         0',
            'Textures (embed.):  0',
            'Materials:          1',
            'Cameras:            0',
            'Lights:             0',
            'Vertices:           18944',
            'Faces:              37884',
            'Bones:              0',
            'Animation Channels: 0',
            'Primitive Types:    triangles',
            'Average faces/mesh  37884',
            'Average verts/mesh  18944',
            'Minimum point      (-46.475552 -46.713150 0.000000)',
            'Maximum point      (46.475552 46.713150 33.647507)',
            'Center point       (0.000000 0.000000 16.823753)',
            '',
            'Named Materials:',
            '    \'DefaultMaterial\'',
            '',
            'Node hierarchy:',
            '\'<STL_BINARY>\', meshes: 1)',
        );

        $result = $this->object->setOutput($testdata);

        $this->assertArrayHasKey('launching_asset_import', $this->object->getOutput());
        $this->assertArrayHasKey('importing_file', $this->object->getOutput());
        $this->assertArrayHasKey('import_time', $this->object->getOutput());
    }
}