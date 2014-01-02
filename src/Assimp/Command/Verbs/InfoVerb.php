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

/**
 * Assimp Info Verb
 *
 * @author magdev
 */
class InfoVerb extends AbstractVerb implements CacheableVerbInterface, InputFileVerbInterface
{
	use Traits\InputFileTrait;

    /** @var string */
    protected $name = 'info';


    /**
     * Set the raw argument
     *
     * @param boolean $raw
     * @return \Assimp\Command\Verbs\InfoVerb
     */
    public function setRaw($raw)
    {
        $this->setArgument('raw', (boolean) $raw);
        return $this;
    }


    /**
     * Get the raw argument
     *
     * @return boolean
     */
    public function getRaw()
    {
        return $this->getArgument('raw');
    }


    /**
     * @see \Assimp\Command\Verbs\CacheableVerbInterface::getCacheKey()
     */
    public function getCacheKey()
    {
        return $this->getName().(int) $this->getRaw();
    }


    /**
     * @see \Assimp\Command\Verbs\AbstractVerb::parseResult()
     */
    public function parseResult(Result $result)
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
	    		} else if (preg_match('/^Named Materials:/', $line)) {
	    			$key = 'named_materials';
	    			$value = $cleanup($lines[$i+1]);
	    		} else if (preg_match('/^Node hierarchy:/', $line)) {
	    			$key = 'node_hierarchy';
	    			$value = array_map($cleanup, explode(',', trim($lines[$i+1])));
	    		}
	    		$data[$key] = $value;
    		}
    	}
    	$result->setOutput($data);
    	return $this;
    }
}