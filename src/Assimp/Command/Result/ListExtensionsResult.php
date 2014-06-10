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
 * Result class for ListExtensionsVerb
 *
 * @author magdev
 */
class ListExtensionsResult extends AbstractResult
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
            return str_replace('*.', '', $value);
        };

		if (sizeof($this->getOutput()) === 1) {
            $extensions = explode(';', $this->getOutputLine(0));
            if (sizeof($extensions)) {
	            $this->parsed = true;
	            $this->setOutput(array_map($cleanup, $extensions));
            }
        }
        return $this;
	}
}