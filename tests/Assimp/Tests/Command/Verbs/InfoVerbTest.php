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

}