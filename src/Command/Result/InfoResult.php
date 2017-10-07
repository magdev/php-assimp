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

namespace Assimp\Command\Result;

/**
 * Result class for InfoVerb
 *
 * @author magdev
 */
class InfoResult extends AbstractResult
{
	/**
	 * @see \Assimp\Command\Result\AbstractResult::parse()
	 */
	protected function parse()
	{
    	if ($this->isParsed()) {
    		return $this;
    	}

		/**
         * Cleanup Callback
         *
         * @param string $value
         * @return string
         */
        $cleanup = function($value) {
            return trim(str_replace(array('\'', ')'), '', $value));
        };

        $data = array();
        $lines = $this->getOutput();
        foreach ($lines as $i => $line) {
            $line = trim($line);
            if ($line) {
            	$key = null;
            	$value = null;
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
                if ($key && $value) {
                	$data[$key] = $value;
                }
            }
        }
        if (sizeof($data)) {
        	$this->parsed = true;
        	$this->setOutput($data);
        }
        return $this;
	}
}
