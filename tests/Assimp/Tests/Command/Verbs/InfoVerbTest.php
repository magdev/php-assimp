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

use Assimp\Command\Verbs\InfoVerb;

/**
 * Test for InfoVerb
 *
 * @author magdev
 */
class InfoVerbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Verbs\InfoVerb
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new InfoVerb();
    }


    /**
     * @covers Assimp\Command\Verbs\InfoVerb::getRaw
     * @covers Assimp\Command\Verbs\InfoVerb::setRaw
     * @covers Assimp\Command\Verbs\InfoVerb::getCacheKey
     */
    public function testGetSetRawCacheKey()
    {
        $this->object->setRaw(false);
        $this->assertFalse($this->object->getRaw());
        $this->assertEquals('info0', $this->object->getCacheKey());

        $this->object->setRaw(true);
        $this->assertTrue($this->object->getRaw());
        $this->assertEquals('info1', $this->object->getCacheKey());
    }


    /**
     * @covers Assimp\Command\Verbs\InfoVerb::parseResult
     */
    public function testResultParserDefault()
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

        $this->object->getResult()->setOutput($testdata);
        $result = $this->object->getResult();

        $this->assertArrayHasKey('launching_asset_import', $result->getOutput());
        $this->assertArrayHasKey('importing_file', $result->getOutput());
        $this->assertArrayHasKey('import_time', $result->getOutput());
    }
}