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

namespace Assimp\Tests\Command;


use Assimp\Converter\FileConverter;

/**
 * Test for Assim File-Converter
 *
 * @author magdev
 */
class FileConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Assimp\Converter\FileConverter
     */
    protected $object;


    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->object = new FileConverter();
    }


    /**
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        system('rm -f '.ASSIMP_TEST_FILES.'/output/* 2>&1 >> /dev/null');
    }


    /**
     * Test conversion ASCII-STL -> ASCII-STL (normalization)
     *
     * @covers Assimp\Converter\FileConverter::convert
     * @covers Assimp\Converter\FileConverter::getVerb
     */
    public function testConvertSTLASCII()
    {
        $inputFile = ASSIMP_TEST_FILES.'/ascii.stl';
        $outputFile = ASSIMP_TEST_FILES.'/output/ascii-converted.stl';

        $this->object->getVerb()->setFile($inputFile);
        $result = $this->object->convert($outputFile, 'stl');
        $this->assertTrue($result->isSuccess());
        $this->assertTrue(file_exists($result->getVerb()->getOutputFile()));
    }


    /**
     * Test conversion ASCII-STL -> OBJ
     *
     * @covers Assimp\Converter\FileConverter::convert
     * @covers Assimp\Converter\FileConverter::getVerb
     */
    public function testConvertSTLASCII2Obj()
    {
        $inputFile = ASSIMP_TEST_FILES.'/ascii.stl';
        $outputFile = ASSIMP_TEST_FILES.'/output/ascii.obj';

        $this->object->getVerb()->setFile($inputFile);
        $result = $this->object->convert($outputFile, 'obj');
        $this->assertTrue($result->isSuccess());
        $this->assertTrue(file_exists($result->getVerb()->getOutputFile()));
    }


    /**
     * Test conversion Binary-STL -> Binary-STL (normalization)
     *
     * @covers Assimp\Converter\FileConverter::convert
     * @covers Assimp\Converter\FileConverter::getVerb
     */
    public function testConvertSTLBinary()
    {
        $inputFile = ASSIMP_TEST_FILES.'/binary.stl';
        $outputFile = ASSIMP_TEST_FILES.'/output/binary-converted.stl';

        $this->object->getVerb()->setFile($inputFile);
        $result = $this->object->convert($outputFile, 'stl');
        $this->assertTrue($result->isSuccess());
        $this->assertTrue(file_exists($result->getVerb()->getOutputFile()));
    }


    /**
     * Test conversion Binary-STL -> OBJ
     *
     * @covers Assimp\Converter\FileConverter::convert
     * @covers Assimp\Converter\FileConverter::getVerb
     */
    public function testConvertSTLBinary2Obj()
    {
        $inputFile = ASSIMP_TEST_FILES.'/binary.stl';
        $outputFile = ASSIMP_TEST_FILES.'/output/binary.obj';

        $this->object->getVerb()->setFile($inputFile);
        $result = $this->object->convert($outputFile, 'obj');
        $this->assertTrue($result->isSuccess());
        $this->assertTrue(file_exists($result->getVerb()->getOutputFile()));
    }
}