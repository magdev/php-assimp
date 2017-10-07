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
use Assimp\Command\Verbs\Container\ParameterContainer;

/**
 * Trait for verbs using parameters
 *
 * @author magdev
 */
trait ParameterTrait
{
    /** @var \Assimp\Command\Verbs\Container\ParameterContainer */
    protected $parameters = null;


    /**
     * Set the parameter container
     *
     * @param \Assimp\Command\Verbs\Container\ParameterContainer $parameters
     * @return \Assimp\Command\Verbs\Traits\ParameterTrait
     */
    public function setParameterContainer(ParameterContainer $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Get the parameter container
     *
     * @return \Assimp\Command\Verbs\Container\ParameterContainer
     */
    public function getParameterContainer()
    {
        if (!$this->parameters) {
            $this->parameters = new ParameterContainer();
        }
        return $this->parameters;
    }


    /**
     * Set multiple parameters
     *
     * @param array $params
     * @return \Assimp\Command\Verbs\ExportVerb
     * @deprecated Use ParameterContainer methods
     */
    public function setParameters(array $params)
    {
        foreach ($params as $name => $value) {
            $this->getParameterContainer()->add($name, $value);
        }
        return $this;
    }


    /**
     * Get all parameters
     *
     * @param boolean $asString
     * @return \Assimp\Command\Verbs\Container\ParameterContainer
     * @deprecated Use ParameterContainer methods
     */
    public function getParameters($asString = false)
    {
        if ($asString) {
            $str = (string) $this->getParameterContainer();
            return $str;
        }
        return $this->getParameterContainer()->all();
    }


    /**
     * Set a specific parameter
     *
     * @param string $name
     * @param mixed $value
     * @return \Assimp\Command\Verbs\ExportVerb
     * @deprecated Use ParameterContainer methods
     */
    public function setParameter($name, $value)
    {
        $this->getParameterContainer()->add($name, $value);
        return $this;
    }


    /**
     * Get a specific parameter
     *
     * @param string $name
     * @return mixed
     * @deprecated Use ParameterContainer methods
     */
    public function getParameter($name)
    {
        return $this->getParameterContainer()->get($name);
    }


    /**
     * Check if a specific parameter is set
     *
     * @param string $name
     * @return boolean
     * @deprecated Use ParameterContainer methods
     */
    public function hasParameter($name)
    {
        return $this->getParameterContainer()->has($name);
    }


    /**
     * Remove a parameter
     *
     * @param string $name
     * @return \Assimp\Command\Verbs\ExportVerb
     * @deprecated Use ParameterContainer methods
     */
    public function removeParameter($name)
    {
        if ($this->hasParameter($name)) {
            $this->getParameterContainer()->remove($name);
        }
        return $this;
    }
}