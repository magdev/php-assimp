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

use Assimp\Command\Verbs\DumpVerb;

/**
 * Test for DumpVerb
 *
 * @author magdev
 */
class DumpVerbTest extends \PHPUnit_Framework_TestCase
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
        $this->object = new DumpVerb();

        $this->testFile = ASSIMP_TEST_FILES.'/ascii.stl';
        $this->outputFile = ASSIMP_TEST_FILES.'/ascii.assxml';
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::getBinary
     * @covers Assimp\Command\Verbs\DumpVerb::setBinary
     */
    public function testGetSetBinary()
    {
        $this->object->setBinary(true);
        $this->assertTrue($this->object->getBinary());

        $this->object->setBinary(false);
        $this->assertFalse($this->object->getBinary());
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::getCompressed
     * @covers Assimp\Command\Verbs\DumpVerb::setCompressed
     */
    public function testGetSetCompressed()
    {
        $this->object->setCompressed(true);
        $this->assertTrue($this->object->getCompressed());

        $this->object->setCompressed(false);
        $this->assertFalse($this->object->getCompressed());
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::getShortened
     * @covers Assimp\Command\Verbs\DumpVerb::setShortened
     */
    public function testGetSetShortened()
    {
        $this->object->setShortened(true);
        $this->assertTrue($this->object->getShortened());

        $this->object->setShortened(false);
        $this->assertFalse($this->object->getShortened());
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::getOutputFile
     * @covers Assimp\Command\Verbs\DumpVerb::setOutputFile
     */
    public function testGetSetOutputFileSuccess()
    {
        $this->assertInstanceOf('\Assimp\Command\Verbs\DumpVerb', $this->object->setOutputFile($this->outputFile));
        $this->assertEquals($this->outputFile, $this->object->getOutputFile());
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::setOutputFile
     * @expectedException \InvalidArgumentException
     */
    public function testGetSetOutputFileFailureInvalidFile()
    {
        $this->object->setOutputFile('/path/to/invalid/file.assxml');
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::setOutputFile
     * @expectedException \InvalidArgumentException
     */
    public function testGetSetOutputFileFailureExistingFile()
    {
        $this->object->setOutputFile($this->testFile);
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::setParameters
     * @covers Assimp\Command\Verbs\DumpVerb::getParameters
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
     * @covers Assimp\Command\Verbs\DumpVerb::setParameter
     * @covers Assimp\Command\Verbs\DumpVerb::getParameter
     * @covers Assimp\Command\Verbs\DumpVerb::hasParameter
     * @covers Assimp\Command\Verbs\DumpVerb::removeParameter
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
     * @covers Assimp\Command\Verbs\DumpVerb::getCommand
     */
    public function testGetCommandSuccess()
    {
        $this->object->setFile($this->testFile);
        $this->assertEquals('dump '.$this->testFile.' '.$this->outputFile, $this->object->getCommand());
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::getCommand
     * @expectedException \RuntimeException
     */
    public function testGetCommandFailure()
    {
        $this->object->getCommand();
    }


    /**
     * @covers Assimp\Command\Verbs\DumpVerb::getParameterContainer
     */
    public function testGetParameterContainer()
    {
        $this->assertInstanceOf('\Assimp\Command\Verbs\Container\ParameterContainer', $this->object->getParameterContainer());
    }
}