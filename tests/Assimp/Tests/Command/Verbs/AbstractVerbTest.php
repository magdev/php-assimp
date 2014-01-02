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

use Assimp\Command\Verbs\AbstractVerb;
use Assimp\Command\CommandException;
use Assimp\Command\Result;


/**
 * Test-Proxy for AbstractVerb
 *
 * @author magdev
 */
class AbstractVerbProxy extends AbstractVerb
{
    protected $name = 'testproxy';
}


/**
 * Test for AbstractVerb
 *
 * @author magdev
 */
class AbstractVerbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Tests\Command\Verbs\AbstractVerbProxy
     */
    protected $object;

    /**
     * @var string
     */
    private $testFile;



    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new AbstractVerbProxy();

        $this->testFile = ASSIMP_TEST_FILES.'/ascii.stl';
    }


    /**
     * @covers Assimp\Command\Verbs\AbstractVerb::getName
     */
    public function testGetName()
    {
        $this->assertEquals('testproxy', $this->object->getName());
    }


    /**
     * @covers Assimp\Command\Verbs\AbstractVerb::getArgumentContainer
     */
    public function testGetArgumentContainer()
    {
        $this->assertInstanceOf('\Assimp\Command\Verbs\Container\ParameterContainer', $this->object->getArgumentContainer());
    }


    /**
     * @covers Assimp\Command\Verbs\AbstractVerb::setArguments
     * @covers Assimp\Command\Verbs\AbstractVerb::getArguments
     */
    public function testGetSetArguments()
    {
        $this->object->setArguments(array('var1' => 'val1'));
        $this->assertArrayHasKey('var1', $this->object->getArguments());

        $this->object->setArguments(array('var2' => 'val2'));
        $this->assertArrayHasKey('var1', $this->object->getArguments());
        $this->assertArrayHasKey('var2', $this->object->getArguments());

        $this->assertEquals('--var1=val1 --var2=val2', $this->object->getArguments(true));
    }


    /**
     * @covers Assimp\Command\Verbs\AbstractVerb::setArgument
     * @covers Assimp\Command\Verbs\AbstractVerb::getArgument
     * @covers Assimp\Command\Verbs\AbstractVerb::hasArgument
     * @covers Assimp\Command\Verbs\AbstractVerb::removeArgument
     */
    public function testGetSetHasRemoveArgument()
    {
        $this->object->setArgument('var1', 'val1');
        $this->assertTrue($this->object->hasArgument('var1'));
        $this->assertEquals('val1', $this->object->getArgument('var1'));

        $this->object->removeArgument('var1');
        $this->assertFalse($this->object->hasArgument('var1'));
    }


    /**
     * @covers Assimp\Command\Verbs\AbstractVerb::getCommand
     */
    public function testGetCommandSuccess()
    {
        $this->assertEquals('testproxy', $this->object->getCommand());
    }


    /**
     * @covers Assimp\Command\Verbs\AbstractVerb::setResult
     * @covers Assimp\Command\Verbs\AbstractVerb::getResult
     */
    public function testSetGetResult()
    {
        $result1 = new Result();
        $result2 = $this->object->getResult();

        $this->assertInstanceOf('\Assimp\Command\Result', $result2);

        $this->assertInstanceOf('\Assimp\Tests\Command\Verbs\AbstractVerbProxy', $this->object->setResult($result1));
        $this->assertNotSame($result2, $this->object->getResult());

        $this->assertInstanceOf('\Assimp\Tests\Command\Verbs\AbstractVerbProxy', $this->object->setResult($result2));
        $this->assertSame($result2, $this->object->getResult());
    }
}