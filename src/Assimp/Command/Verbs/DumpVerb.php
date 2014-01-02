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


namespace Assimp\Command\Verbs;

use Assimp\Command\Result;
use Assimp\Command\Verbs\Container\ParameterContainer;
use Assimp\ErrorCodes;

/**
 * Assimp DumpVerb
 *
 * @author magdev
 */
class DumpVerb extends AbstractVerb implements Interfaces\InputFileVerbInterface
{
	use Traits\InputFileTrait;
	use Traits\OutputFileTrait;
	use Traits\ParameterTrait;

    /** @var string */
    protected $name = 'dump';


    /**
     * Set the output mode binary
     *
     * @param boolean $value
     * @return \Assimp\Command\Verbs\DumpVerb
     */
    public function setBinary($value = true)
    {
    	$this->setArgument('b', (boolean) $value);
    	return $this;
    }


    /**
     * Get the binary mode
     *
     * @return boolean
     */
    public function getBinary()
    {
    	$value = (boolean) $this->getArgument('b');
    	return $value;
    }


    /**
     * Set the output mode shortened
     *
     * @param boolean $value
     * @return \Assimp\Command\Verbs\DumpVerb
     */
    public function setShortened($value = true)
    {
    	$this->setArgument('s', (boolean) $value);
    	return $this;
    }


    /**
     * Get the shortened mode
     *
     * @return boolean
     */
    public function getShortened()
    {
    	$value = (boolean) $this->getArgument('s');
    	return $value;
    }


    /**
     * Set the output mode compressed
     *
     * @param boolean $value
     * @return \Assimp\Command\Verbs\DumpVerb
     */
    public function setCompressed($value = true)
    {
    	$this->setArgument('z', (boolean) $value);
    	return $this;
    }


    /**
     * Get the compressed mode
     *
     * @return boolean
     */
    public function getCompressed()
    {
    	$value = (boolean) $this->getArgument('z');
    	return $value;
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
    		$ext = $this->getBinary() ? 'assbin' : 'assxml';
    		$this->outputFile = $dir.'/'.$basename.'.'.$ext;
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


    /**
     * @see \Assimp\Command\Verbs\AbstractVerb::parseResult()
     */
    protected function parseResult(Result $result)
    {
    	$lines = $result->getOutput();
    	if (!sizeof($lines)) {
    		return $result;
    	}

    	$cleanup = function($value) {
    		return trim(str_replace(array('\'', ')'), '', $value));
    	};

    	$data = array();
    	foreach ($lines as $i => $line) {
    		$line = trim($line);
    		if ($line) {
    			$parts = array();
    			if (preg_match('/^([\w\s\/]+)[\s\.:]+([\d]+|[\w]+|[\d]+\sB|\([\d\.\s-]+\))$/', $line, $parts)) {
    				$key = preg_replace('/[^\d\w]+/', '_', strtolower(trim($parts[1])));
    				$value = trim($parts[2]);
    				$points = array();
    				if (preg_match('/\(.+\)/', $value)) {
    					$value = explode(' ', trim($value, '()'));
    				}
    			} else if (preg_match('/^import took approx\.\s([\d\.]+)\s([\w]+)/', $line, $parts)) {
    				$key = 'import_time';
    				$value = $parts[1].' '.ucfirst($parts[2]);
    			}
    			$data[$key] = $value;
    		}
    	}
    	$result->setOutput($data);
    	return $this;
    }
}