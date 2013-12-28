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

use Assimp\Command\Verbs\ExportVerb;

/**
 * Test for ExportVerb
 *
 * @author magdev
 */
class ExportVerbTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Assimp\Command\Verbs\ExportVerb
	 */
	protected $object;

	private $testFile;
	private $outputFile;

	/**
	 * Setup
	 */
	protected function setUp()
	{
		$this->object = new ExportVerb();

		$this->testFile = ASSIMP_TEST_FILES.'/ascii.stl';
		$this->outputFile = ASSIMP_TEST_FILES.'/output/test.stl';
	}

	/**
	 * Cleanup
	 */
	protected function tearDown()
	{
		if (file_exists($this->outputFile)) {
			unlink($this->outputFile);
		}
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::getFormat
	 * @covers Assimp\Command\Verbs\ExportVerb::setFormat
	 */
	public function testGetSetFormat()
	{
		$this->object->setFormat('stl');
		$this->assertEquals('stl', $this->object->getFormat());
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::getOutputFile
	 * @covers Assimp\Command\Verbs\ExportVerb::setOutputFile
	 */
	public function testGetSetOutputFileSuccess()
	{
		$this->assertInstanceOf('\Assimp\Command\Verbs\ExportVerb', $this->object->setOutputFile($this->outputFile));
		$this->assertEquals($this->outputFile, $this->object->getOutputFile());
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::setOutputFile
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetSetOutputFileFailureInvalidFile()
	{
		$this->object->setOutputFile('/path/to/invalid/file.stl');
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::setOutputFile
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetSetOutputFileFailureExistingFile()
	{
		$this->object->setOutputFile($this->testFile);
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::setParameters
	 * @covers Assimp\Command\Verbs\ExportVerb::getParameters
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
	 * @covers Assimp\Command\Verbs\ExportVerb::setParameter
	 * @covers Assimp\Command\Verbs\ExportVerb::getParameter
	 * @covers Assimp\Command\Verbs\ExportVerb::hasParameter
	 * @covers Assimp\Command\Verbs\ExportVerb::removeParameter
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
	 * @covers Assimp\Command\Verbs\ExportVerb::getCommand
	 */
	public function testGetCommandSuccess()
	{
		$this->object->setFile($this->testFile);
		$this->object->setOutputFile($this->outputFile);
		$this->assertEquals('export '.$this->testFile.' '.$this->outputFile, $this->object->getCommand());
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::getCommand
	 * @expectedException \RuntimeException
	 */
	public function testGetCommandFailureNoFiles()
	{
		$this->object->getCommand();
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::getCommand
	 * @expectedException \RuntimeException
	 */
	public function testGetCommandFailureNoInputFile()
	{
		$this->object->setOutputFile($this->outputFile);
		$this->object->getCommand();
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::getCommand
	 * @expectedException \RuntimeException
	 */
	public function testGetCommandFailureNoOutputFile()
	{
		$this->object->setFile($this->testFile);
		$this->object->getCommand();
	}


	/**
	 * @covers Assimp\Command\Verbs\ExportVerb::getParameterContainer
	 */
	public function testGetParameterContainer()
	{
		$this->assertInstanceOf('\Assimp\Command\Verbs\Container\ParameterContainer', $this->object->getParameterContainer());
	}
}