<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\ApiDoc;

use Vegas\ApiDoc\Exception\CollectionArgumentNotFoundException;

/**
 * Class CollectionAbstract
 * @package Vegas\ApiDoc
 */
abstract class CollectionAbstract implements \ArrayAccess
{
    /**
     * Sets argument for collection object
     * Each argument must be represented by public property in child class
     *
     * @param $argument
     * @param $value
     * @throws Exception\CollectionArgumentNotFoundException
     */
    public function setArgument($argument, $value)
    {
        try {
            $reflectionProperty = new \ReflectionProperty($this, $argument);
            if (!$reflectionProperty->isPublic()) {
                throw new \ReflectionException();
            }
            $reflectionProperty->setValue($this, $value);
        } catch (\ReflectionException $e) {
            throw new CollectionArgumentNotFoundException(get_called_class(), $argument);
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * @param $name
     * @return mixed
     * @throws CollectionArgumentNotFoundException
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param $argument
     * @return bool
     */
    public function hasArgument($argument)
    {
        try {
            $reflectionProperty = new \ReflectionProperty($this, $argument);
        } catch (\ReflectionException $e) {
            return false;
        }
        return $reflectionProperty->isPublic();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->hasArgument($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @throws \CollectionArgumentNotFoundException
     * @throws \Phalcon\Exception
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if ($offset == 'slug') {
            return \Phalcon\Utils\Slug::generate($this->offsetGet('name'));
        }
        if (!$this->hasArgument($offset)) {
            throw new \CollectionArgumentNotFoundException(get_called_class(), $offset);
        }
        return $this->{$offset};
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->setArgument($offset, $value);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @throws CollectionArgumentNotFoundException
     * @return void
     */
    public function offsetUnset($offset)
    {
        if (!$this->hasArgument($offset)) {
            throw new CollectionArgumentNotFoundException(get_called_class(), $offset);
        }
        $this->{$offset} = null;
    }
}