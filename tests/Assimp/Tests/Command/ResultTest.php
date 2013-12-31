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

namespace Assimp\Tests\Command;

use Assimp\Command\Result;
use Assimp\Command\Verbs\VersionVerb;

/**
 * Test for Assimp Result
 *
 * @author magdev
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Result
     */
    protected $object;

    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new Result();
    }


    /**
     * @covers Assimp\Command\Result::setCommand
     * @covers Assimp\Command\Result::getCommand
     */
    public function testGetSetCommand()
    {
        $command = '/test/command -p';
        $this->assertInstanceOf('\Assimp\Command\Result', $this->object->setCommand($command));
        $this->assertEquals($command, $this->object->getCommand());
    }


    /**
     * @covers Assimp\Command\Result::isSuccess
     */
    public function testIsSuccess()
    {
        $this->assertFalse($this->object->isSuccess());

        $this->object->setExitCode(1);
        $this->assertFalse($this->object->isSuccess());

        $this->object->setExitCode(0);
        $this->assertTrue($this->object->isSuccess());
    }


    /**
     * @covers Assimp\Command\Result::setVerb
     * @covers Assimp\Command\Result::getVerb
     */
    public function testGetSetVerb()
    {
        $verb = new VersionVerb();
        $this->assertInstanceOf('\Assimp\Command\Result', $this->object->setVerb($verb));
        $this->assertSame($verb, $this->object->getVerb());
    }


    /**
     * @covers Assimp\Command\Result::setOutput
     * @covers Assimp\Command\Result::getOutput
     * @covers Assimp\Command\Result::getOutputLine
     * @covers Assimp\Command\Result::addOutput
     */
    public function testGetSetAddOutput()
    {
        $output = array('line1', 'line2');

        $this->assertInstanceOf('\Assimp\Command\Result', $this->object->setOutput($output));
        $this->assertCount(2, $this->object->getOutput());
        $this->assertEquals('line1', $this->object->getOutputLine(0));
        $this->assertEquals('line2', $this->object->getOutputLine(1));

        $this->assertInstanceOf('\Assimp\Command\Result', $this->object->addOutput('line3'));
        $this->assertCount(3, $this->object->getOutput());
        $this->assertEquals('line3', $this->object->getOutputLine(2));

        $this->assertInstanceOf('\Assimp\Command\Result', $this->object->setOutput($output));
        $this->assertEquals('line1', $this->object->getOutputLine(0));
        $this->assertEquals('line2', $this->object->getOutputLine(1));
    }
}