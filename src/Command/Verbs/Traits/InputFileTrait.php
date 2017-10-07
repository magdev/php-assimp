<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Marco Graetsch <magdev3.0@googlemail.com>
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
 * @copyright 2014 Marco Graetsch <magdev3.0@googlemail.com>
 * @package   php-assimp
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace Assimp\Command\Verbs\Traits;

use Assimp\ErrorCodes;

/**
 * Trait for verbs using input files
 *
 * @author magdev
 */
trait InputFileTrait
{
    /** @var string */
    protected $file = null;


    /**
     * Set the input file
     *
     * @param string $file
     * @throws \InvalidArgumentException
     * @return \Assimp\Command\Verbs\Traits\InputFileTrait
     */
    public function setFile($file)
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException('File not found: '.$file, ErrorCodes::FILE_NOT_FOUND);
        }
        if (!is_readable($file)) {
            throw new \InvalidArgumentException('File is not readable: '.$file, ErrorCodes::FILE_NOT_READABLE);
        }
        $this->file = $file;
        return $this;
    }


    /**
     * Get the input file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}