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

namespace Assimp\Tests\Command\Verbs\Container;

use Assimp\Command\Verbs\Container\ParameterContainer;

/**
 * Test for ParameterContainer
 */
class ParameterContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Command\Verbs\Container\ParameterContainer
     */
    protected $object;


    /**
     * Setup
     */
    protected function setUp()
    {
        $this->object = new ParameterContainer();
    }


    /**
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::get
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::set
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::add
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::has
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::remove
     */
    public function testGetSetAddHasValue()
    {
        $this->object->add('var1', 1);
        $this->assertTrue($this->object->has('var1'));
        $this->assertEquals(1, $this->object->get('var1'));

        $this->object->remove('var1');
        $this->assertFalse($this->object->has('var1'));

        $this->object->set(array('var2' => 2));
        $this->assertTrue($this->object->has('var2'));
        $this->assertEquals(2, $this->object->get('var2'));

        $this->object->remove('var2');
        $this->assertFalse($this->object->has('var2'));
    }


    /**
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::__toString
     * @covers Assimp\Command\Verbs\Container\ParameterContainer::all
     */
    public function test__toString()
    {
        $this->object->set(array('var1' => 1));
        $this->assertEquals('--var1=1', (string) $this->object);

        $this->object->remove('var1')->add('v', 1);
        $this->assertEquals('-v1', (string) $this->object);

        $this->object->set(array('var1' => 2));
        $this->assertEquals('-v1 --var1=2', (string) $this->object);
    }
}
