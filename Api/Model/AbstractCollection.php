<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 16/01/2014
 * Time: 21:02
 */

namespace Api\Model;
use \Iterator, \Countable, \ArrayAccess;

abstract class AbstractCollection implements Iterator, Countable, ArrayAccess
{
    protected $_entities = array();
    protected $_entityClass;

    /**
     * Constructor
     */
    public function  __construct(array $entities = array(), $entityClass = null)
    {
        if (!empty($entities)) {
            $this->_entities = $entities;
        }
        $this->_entityClass = $entityClass;
        $this->rewind();
    }

    /**
     * Reset the collection (implementation required by Iterator Interface)
     */
    public function rewind()
    {
        reset($this->_entities);
    }

    /**
     * Get the entities stored in the collection
     */
    public function getEntities()
    {
        return $this->_entities;
    }

    /**
     * Clear the collection
     */
    public function clear()
    {
        $this->_entities = array();
    }

    /**
     * Move to the next entity in the collection (implementation required by Iterator Interface)
     */
    public function next()
    {
        next($this->_entities);
    }

    /**
     * Get the key of the current entity in the collection (implementation required by Iterator Interface)
     */
    public function key()
    {
        return key($this->_entities);
    }

    /**
     * Check if there're more entities in the collection (implementation required by Iterator Interface)
     */
    public function valid()
    {
        return ($this->current() !== false);
    }

    /**
     * Get the current entity in the collection (implementation required by Iterator Interface)
     */
    public function current()
    {
        return current($this->_entities);
    }

    /**
     * Count the number of entities in the collection (implementation required by Countable Interface)
     */
    public function count()
    {
        return count($this->_entities);
    }

    /**
     * Add an entity to the collection (implementation required by ArrayAccess interface)
     */
    public function offsetSet($key, $entity)
    {

            if (!isset($key)) {
                $this->_entities[] = $entity;
            }
            else {
                $this->_entities[$key] = $entity;
            }
            return true;

    }

    /**
     * Remove an entity from the collection (implementation required by ArrayAccess interface)
     */
    public function offsetUnset($key)
    {
        if ($key instanceof $this->_entityClass) {
            $this->_entities = array_filter($this->_entities, function ($v) use ($key) {
                return $v !== $key;
            });
            return true;
        }
        if (isset($this->_entities[$key])) {
            unset($this->_entities[$key]);
            return true;
        }
        return false;
    }

    /**
     * Get the specified entity in the collection (implementation required by ArrayAccess interface)
     */
    public function offsetGet($key)
    {
        return isset($this->_entities[$key]) ?
            $this->_entities[$key] :
            null;
    }

    /**
     * Check if the specified entity exists in the collection (implementation required by ArrayAccess interface)
     */
    public function offsetExists($key)
    {
        return isset($this->_entities[$key]);
    }
}
