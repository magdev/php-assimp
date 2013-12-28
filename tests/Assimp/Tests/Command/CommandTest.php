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

use Assimp\Command\Command;

/**
 * Test for Assimp Command
 *
 * @author magdev
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Command
     */
    protected $object;

    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new Command();
    }


    /**
     * @covers Assimp\Command\Command::execute
     */
    public function testExecute()
    {
        $verb = $this->getMock('\Assimp\Command\Verbs\VersionVerb', array('getCommand'));

        $verb->expects($this->once())
            ->method('getCommand')
            ->will($this->returnValue('help'));

        $this->assertTrue($this->object->execute($verb, true));
    }


    /**
     * @covers Assimp\Command\Command::getBinary
     */
    public function testGetBinary()
    {
        $this->assertEquals('/usr/bin/assimp', $this->object->getBinary());
    }


    /**
     * @covers Assimp\Command\Command::setBinary
     */
    public function testSetBinarySuccess()
    {
        $this->assertInstanceOf('\Assimp\Command\Command', $this->object->setBinary('/usr/bin/assimp'));
    }


    /**
     * @covers Assimp\Command\Command::setBinary
     * @expectedException \InvalidArgumentException
     */
    public function testSetBinaryFailure()
    {
        $this->object->setBinary('/usr/local/bin/assimp');
    }
}
