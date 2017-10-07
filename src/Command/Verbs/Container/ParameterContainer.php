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

namespace Assimp\Command\Verbs\Container;


/**
 * Container for command-line arguments
 *
 * @author magdev
 */
class ParameterContainer
{
    /** @var array */
    protected $parameters = array();



    /**
     * Constructor
     *
     * @param array|null $parameters
     */
    public function __construct(array $parameters = null)
    {
        if (is_array($parameters)) {
            $this->set($parameters);
        }
    }


    /**
     * Get a parameter value
     *
     * @param string $parameter
     * @param mixed $default
     * @return mixed
     */
    public function get($parameter, $default = null)
    {
        return $this->has($parameter) ? $this->parameters[$parameter] : $default;
    }


    /**
     * Set all parameters at once
     *
     * @param array $parameters
     * @return \Assimp\Command\Verbs\Container\ParameterContainer
     */
    public function set(array $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            $this->add($parameter, $value);
        }
        return $this;
    }


    /**
     * Add a parameter
     *
     * @param string $parameter
     * @param mixed $value
     * @return \Assimp\Command\Verbs\Container\ParameterContainer
     */
    public function add($parameter, $value)
    {
        $this->parameters[$parameter] = $value;
        return $this;
    }


    /**
     * Check if a parameter is set
     *
     * @param string $parameter
     * @return boolean
     */
    public function has($parameter)
    {
        return array_key_exists($parameter, $this->all());
    }


    /**
     * Get all parameters as array
     *
     * @return array
     */
    public function all()
    {
        return $this->parameters;
    }


    /**
     * Remove a parameter
     *
     * @param string $parameter
     * @return \Assimp\Command\Verbs\Container\ParameterContainer
     */
    public function remove($parameter)
    {
        if ($this->has($parameter)) {
            unset($this->parameters[$parameter]);
        }
        return $this;
    }


    /**
     * Get the parameters as string
     *
     * @return string
     */
    public function __toString()
    {
        $str = '';
        foreach ($this->all() as $parameter => $value) {
            $str .= ' '. $this->format($parameter, $value);
        }
        return trim($str);
    }


    /**
     * Format a parameter/value pair
     *
     * @param string $parameter
     * @param mixed $value
     * @return string
     */
    protected function format($parameter, $value)
    {
        if ($value) {
            if (is_bool($value)) {
                return strlen($parameter) === 1 ? '-'.$parameter : '--'.$parameter;
            }
            return strlen($parameter) === 1 ? '-'.$parameter.$value : '--'.$parameter.'='.$value;
        }
        return '';
    }
}