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
 * @package
 * @license   http://opensource.org/licenses/MIT MIT License
 */


namespace Assimp\Command;

use Assimp\Command\Verbs\VerbInterface;

/**
 * Assimp Command Executor
 *
 * @author magdev
 */
class CommandExecutor
{
	/** @var string */
	private $bin = null;
	
	
	/**
	 * Constructor
	 *
	 * @param string $bin
	 */
	public function __construct($bin = null)
	{
		if (is_string($bin)) {
			$this->setBinary($bin);
		}
	}
	
	
	/**
	 * Execute a command
	 *
	 * @param VerbInterface $verb
	 * @return boolean
	 */
	public function execute(VerbInterface $verb)
	{
		$results = array();
		$exitCode = null;
		
		try {
			$cmd = $this->getBinary().' '.$verb->getCommand();
			exec($cmd, $results, $exitCode);
			
			return $verb->setExitCode($exitCode)
				->setResults($results)
				->isSuccess();
		} catch (\Exception $e) {
			return $verb->setException($e)
				->isSuccess();
		}
	}
	
	
	/**
	 * Get the path to the assimp binary
	 *
	 * @return string
	 */
	public function getBinary()
	{
		if (is_null($this->bin)) {
			$this->setBinary('/usr/bin/assimp');
		}
		return $this->bin;
	}
	
	
	/**
	 * Set the path to the assimp binary
	 *
	 * @param string $bin
	 * @throws \InvalidArgumentException
	 * @return \Assimp\Command\CommandExecutor
	 */
	public function setBinary($bin)
	{
		if (!is_file($bin)) {
			throw new \InvalidArgumentException('Binary file not exists: '.$bin, ErrorCodes::FILE_NOT_FOUND);
		}
		if (!is_executable($bin)) {
			throw new \InvalidArgumentException('Binary file is not executable: '.$bin, ErrorCodes::FILE_NOT_EXECUTABLE);
		}
		$this->bin = $bin;
		return $this;
	}
}