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
 * Trait for verbs using output files
 *
 * @author magdev
 */
trait OutputFileTrait
{
    /** @var string */
    protected $outputFile = null;


    /**
     * Set the output file
     *
     * @param string $file
     * @return \Assimp\Command\Verbs\Traits\OutputFileTrait
     */
    public function setOutputFile($file)
    {
        $dir = dirname($file);
        if (is_file($file)) {
            throw new \InvalidArgumentException('File exists: '.$file, ErrorCodes::FILE_EXISTS);
        }
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException('Directory not exists: '.$dir, ErrorCodes::DIR_NOT_FOUND);
        }
        if (!is_writable($dir)) {
            throw new \InvalidArgumentException('Directory not writeable: '.$dir, ErrorCodes::DIR_NOT_WRITEABLE);
        }
        $this->outputFile = $file;
        return $this;
    }


    /**
     * Get the output file
     *
     * @return string
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }
}