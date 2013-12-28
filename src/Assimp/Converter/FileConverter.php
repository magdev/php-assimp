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

namespace Assimp\Converter;


use Assimp\ErrorCodes;
use Assimp\Command\Command;
use Assimp\Command\Verbs\ExportVerb;
use Assimp\Command\Verbs\VerbInterface;


/**
 * File-Converter for assimp
 *
 * @author magdev
 */
final class FileConverter
{
    /** \Assimp\Command\Verbs\VerbInterface */
    private $verb = null;

    /** \Assimp\Command\Command */
    private static $exec = null;


    /**
     * Constructor
     *
     * @param string $inputFile
     */
    public function __construct($inputFile = null, array $arguments = null)
    {
        if (!is_null($inputFile)) {
            $this->getVerb()->setFile($inputFile);
        }
        if (is_array($arguments)) {
            $this->getVerb()->setArguments($arguments);
        }
    }


    /**
     * Convert a file
     *
     * @param string $outputFile
     * @param string $format
     * @param array $params
     * @return \Assimp\Converter\FileConverter
     * @throws \Assimp\Converter\ConverterException
     */
    public function convert($outputFile, $format, array $params = array())
    {
        try {
            $this->getVerb()->setOutputFile($outputFile)
                ->setFormat($format)
                ->setParameters($params);

            if (!self::getCommand()->execute($this->getVerb())) {
                if ($this->getVerb()->getException()) {
                    throw $this->getVerb()->getException();
                }
                throw new \RuntimeException('Unknown error: ', $this->getVerb()->getExitCode());
            }
        	return $this;
        } catch (\Exception $e) {
            throw new ConverterException('Conversion failed', ErrorCodes::EXECUTION_FAILURE, $e);
        }
    }


    /**
     * Get the verb object
     *
     * @return \Assimp\Command\Verbs\ExportVerb
     */
    public function getVerb()
    {
        if (!$this->verb) {
            $this->verb = new ExportVerb();
        }
        return $this->verb;
    }


    /**
     * Set the verb
     *
     * @param \Assimp\Command\Verbs\ExportVerb $verb
     * @return \Assimp\Converter\FileConverter
     */
    public function setVerb(ExportVerb $verb)
    {
        $this->verb = $verb;
        return $this;
    }


    /**
     * Get the command singleton
     *
     * @return \Assimp\Command\Command
     */
    public static function getCommand()
    {
        if (!is_null(self::$exec)) {
            self::$exec = new Command();
        }
        return self::$exec;
    }


    /**
     * Set the path to the assimp executable
     *
     * @param string $bin
     */
    public static function setBinary($bin)
    {
        self::getCommand()->setBinary($bin);
    }
}