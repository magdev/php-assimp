<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Marco Graetsch <magdev3.0@gmail.com>
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
 * @copyright 2014 Marco Graetsch <magdev3.0@gmail.com>
 * @package   php-assimp
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace Assimp\Tests\Command\Verbs;

use Assimp\Command\Verbs\ExtractVerb;

/**
 * Test for ExtractVerb
 *
 * @author magdev
 */
class ExtractVerbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Verbs\DumpVerb
     */
    protected $object;

    private $testFile;
    private $outputFile;

    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new ExtractVerb();

        $this->testFile = ASSIMP_TEST_FILES.'/ascii.stl';
        $this->outputFile = ASSIMP_TEST_FILES.'/ascii.bmp';
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setBMPAlpha
     * @covers Assimp\Command\Verbs\ExtractVerb::getBMPAlpha
     */
    public function testGetSetBMPAlpha()
    {
        $this->object->setBMPAlpha(true);
        $this->assertTrue($this->object->getBMPAlpha());

        $this->object->setBMPAlpha(false);
        $this->assertFalse($this->object->getBMPAlpha());
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setIndex
     * @covers Assimp\Command\Verbs\ExtractVerb::getIndex
     */
    public function testGetSetIndex()
    {
        $this->object->setIndex(1);
        $this->assertEquals(1, $this->object->getIndex());

        $this->object->setIndex(0);
        $this->assertEquals(0, $this->object->getIndex());
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setFileFormat
     * @covers Assimp\Command\Verbs\ExtractVerb::getFileFormat
     */
    public function testGetSetFileFormat()
    {
        $this->object->setFileFormat(ExtractVerb::FORMAT_BMP);
        $this->assertEquals(ExtractVerb::FORMAT_BMP, $this->object->getFileFormat());

        $this->object->setFileFormat(ExtractVerb::FORMAT_TGA);
        $this->assertEquals(ExtractVerb::FORMAT_TGA, $this->object->getFileFormat());
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::getOutputFile
     * @covers Assimp\Command\Verbs\ExtractVerb::setOutputFile
     */
    public function testGetSetOutputFileSuccess()
    {
        $this->assertInstanceOf('\Assimp\Command\Verbs\ExtractVerb', $this->object->setOutputFile($this->outputFile));
        $this->assertEquals($this->outputFile, $this->object->getOutputFile());
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setOutputFile
     * @expectedException \InvalidArgumentException
     */
    public function testGetSetOutputFileFailureInvalidFile()
    {
        $this->object->setOutputFile('/path/to/invalid/file.png');
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setOutputFile
     * @expectedException \InvalidArgumentException
     */
    public function testGetSetOutputFileFailureExistingFile()
    {
        $this->object->setOutputFile($this->testFile);
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setParameters
     * @covers Assimp\Command\Verbs\ExtractVerb::getParameters
     */
    public function testGetSetParameters()
    {
        $this->object->setParameters(array('var1' => 'val1'));
        $this->assertArrayHasKey('var1', $this->object->getParameters());

        $this->object->setParameters(array('var2' => 'val2'));
        $this->assertArrayHasKey('var1', $this->object->getParameters());
        $this->assertArrayHasKey('var2', $this->object->getParameters());

        $this->assertEquals('--var1=val1 --var2=val2', $this->object->getParameters(true));
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::setParameter
     * @covers Assimp\Command\Verbs\ExtractVerb::getParameter
     * @covers Assimp\Command\Verbs\ExtractVerb::hasParameter
     * @covers Assimp\Command\Verbs\ExtractVerb::removeParameter
     */
    public function testGetSetHasRemoveParameter()
    {
        $this->object->setParameter('var1', 'val1');
        $this->assertTrue($this->object->hasParameter('var1'));
        $this->assertEquals('val1', $this->object->getParameter('var1'));

        $this->object->removeParameter('var1');
        $this->assertFalse($this->object->hasParameter('var1'));
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::getCommand
     */
    public function testGetCommandSuccess()
    {
        $this->object->setFile($this->testFile);
        $this->assertEquals('extract '.$this->testFile.' '.$this->outputFile, $this->object->getCommand());
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::getCommand
     * @expectedException \RuntimeException
     */
    public function testGetCommandFailure()
    {
        $this->object->getCommand();
    }


    /**
     * @covers Assimp\Command\Verbs\ExtractVerb::getParameterContainer
     */
    public function testGetParameterContainer()
    {
        $this->assertInstanceOf('\Assimp\Command\Verbs\Container\ParameterContainer', $this->object->getParameterContainer());
    }
}