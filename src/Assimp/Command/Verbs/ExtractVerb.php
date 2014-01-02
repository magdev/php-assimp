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
 * @package
 * @license   http://opensource.org/licenses/MIT MIT License
 */


namespace Assimp\Command\Verbs;

use Assimp\Command\Result;
use Assimp\ErrorCodes;

/**
 * Assimp ExtractVerb
 *
 * @author magdev
 */
class ExtractVerb extends AbstractVerb implements Interfaces\InputFileInterface, Interfaces\OutputFileInterface
{
	const FORMAT_BMP = 'bmp';
	const FORMAT_TGA = 'tga';


    use Traits\InputFileTrait;
    use Traits\OutputFileTrait;
    use Traits\ParameterTrait;

    /** @var string */
    protected $name = 'extract';


    /**
     * Enable alpha channel on BMP
     *
     * @param boolean $enable
     * @return \Assimp\Command\Verbs\ExtractVerb
     */
    public function setBMPAlpha($enable = true)
    {
    	$this->setArgument('ba', $enable);
    	return $this;
    }


    /**
     * Check if BMP should be written with alpha channels
     *
     * @return boolean
     */
    public function getBMPAlpha()
    {
    	return $this->getArgument('ba');
    }


    /**
     * Set the index of the texture to be extracted (zero-based)
     *
     * @param int $index
     * @return \Assimp\Command\Verbs\ExtractVerb
     */
    public function setIndex($index)
    {
    	$this->setArgument('t', (int) $index);
    	return $this;
    }


    /**
     * Get the index of the texture to be extracted (zero-based)
     *
     * @return \Assimp\Command\Verbs\mixed
     */
    public function getIndex()
    {
    	return $this->getArgument('t');
    }


    /**
     * Set the the file format (if output file is omitted)
     *
     * @param string $format
     * @return \Assimp\Command\Verbs\ExtractVerb
     */
    public function setFileFormat($format)
    {
    	if (!in_array($format, array(self::FORMAT_BMP, self::FORMAT_TGA))) {
    		throw new \InvalidArgumentException('Invalid file format: '.$format, ErrorCodes::INVALID_VALUE);
    	}
    	$this->setArgument('f', $format);
    	return $this;
    }


    /**
     * Get the the file format
     *
     * @return string
     */
    public function getFileFormat()
    {
    	return $this->getArgument('f');
    }


    /**
     * Get the output file
     *
     * @return string
     */
    public function getOutputFile()
    {
    	if (!$this->outputFile) {
    		$dir = rtrim(dirname($this->getFile()), '/\\');
    		$file = basename($this->getFile());
    		$basename = substr($file, 0, strpos($file, '.'));
    		$this->outputFile = $dir.'/'.$basename.'.bmp';
    	}
    	return $this->outputFile;
    }


    /**
     * @see \Assimp\Command\Verbs\AbstractVerb::getCommand()
     */
    public function getCommand()
    {
        if (!$this->getFile()) {
            throw new \RuntimeException('Input-File is required', ErrorCodes::MISSING_VALUE);
        }
        return $this->normalizeCommand($this->getName().' '.$this->getFile().' '.$this->getOutputFile().' '.$this->getArguments(true).' '.$this->getParameters(true));
    }
}