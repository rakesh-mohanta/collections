<?php
namespace Icecave\Collections;

use ArrayAccess;
use Countable;
use Icecave\Collections\Iterator\Traits;
use Icecave\Collections\TypeCheck\TypeCheck;
use Icecave\Parity\Exception\NotComparableException;
use Icecave\Repr\Repr;
use IteratorAggregate;
use Serializable;

/**
 * An associative collection with efficient access by key.
 */
class Map implements MutableAssociativeInterface, Countable, IteratorAggregate, ArrayAccess, Serializable
{
    /**
     * @param mixed<mixed>|null $elements   An iterable type containing the elements to include in this map, or null to create an empty map.
     * @param callable|null     $comparator The function to use for comparing keys, or null to use the default.
     */
    public function __construct($elements = null, $comparator = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $comparator) {
            $comparator = new Detail\ObjectIdentityComparator;
        }

        $this->comparator = $comparator;
        $this->elements = new Vector;

        if (null !== $elements) {
            foreach ($elements as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    public function __clone()
    {
        $this->typeCheck->validateClone(func_get_args());

        $this->elements = clone $this->elements;
    }

    /**
     * Create a Map.
     *
     * @param mixed $element,... Elements to include in the collection.
     *
     * @return Map
     */
    public static function create()
    {
        TypeCheck::get(__CLASS__)->create(func_get_args());

        $map = new static;

        foreach (func_get_args() as $element) {
            list($key, $value) = $element;
            $map->set($key, $value);
        }

        return $map;
    }

    ///////////////////////////////////////////
    // Implementation of CollectionInterface //
    ///////////////////////////////////////////

    /**
     * Fetch the number of elements in the collection.
     *
     * @see Map::isEmpty()
     *
     * @return integer The number of elements in the collection.
     */
    public function size()
    {
        $this->typeCheck->size(func_get_args());

        return $this->elements->size();
    }

    /**
     * Check if the collection is empty.
     *
     * @return boolean True if the collection is empty; otherwise, false.
     */
    public function isEmpty()
    {
        $this->typeCheck->isEmpty(func_get_args());

        return $this->elements->isEmpty();
    }

    /**
     * Fetch a string representation of the collection.
     *
     * The string may not describe all elements of the collection, but should at least
     * provide information on the type and state of the collection.
     *
     * @return string A string representation of the collection.
     */
    public function __toString()
    {
        if ($this->isEmpty()) {
            return '<Map 0>';
        } elseif ($this->size() > 3) {
            $format = '<Map %d [%s, ...]>';
        } else {
            $format = '<Map %d [%s]>';
        }

        $elements = array();
        foreach ($this->elements->slice(0, 3) as $element) {
            list($key, $value) = $element;
            $elements[] = Repr::repr($key) . ' => ' . Repr::repr($value);
        }

        return sprintf(
            $format,
            $this->size(),
            implode(', ', $elements)
        );
    }

    //////////////////////////////////////////////////
    // Implementation of MutableCollectionInterface //
    //////////////////////////////////////////////////

    /**
     * Remove all elements from the collection.
     */
    public function clear()
    {
        $this->typeCheck->clear(func_get_args());

        $this->elements->clear();
    }

    //////////////////////////////////////////////
    // Implementation of IteratorTraitsProvider //
    //////////////////////////////////////////////

    /**
     * Return traits describing the collection's iteration capabilities.
     *
     * @return Traits
     */
    public function iteratorTraits()
    {
        $this->typeCheck->iteratorTraits(func_get_args());

        return new Traits(true, true);
    }

    /////////////////////////////////////////
    // Implementation of IterableInterface //
    /////////////////////////////////////////

    /**
     * Fetch a native array containing the elements in the collection.
     *
     * @return array An array containing the elements in the collection.
     */
    public function elements()
    {
        $this->typeCheck->elements(func_get_args());

        return $this->elements->elements();
    }

    /**
     * Check if the collection contains an element with the given value.
     *
     * @param mixed $value The value to check.
     *
     * @return boolean True if the collection contains $value; otherwise, false.
     */
    public function contains($value)
    {
        $this->typeCheck->contains(func_get_args());

        foreach ($this->elements as $element) {
            list(, $v) = $element;
            if ($v === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Fetch a new collection with a subset of the elements from this collection.
     *
     * The predicate must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return $true_to_retain_element; }
     *
     * @param callable|null $predicate A predicate function used to determine which elements to include, or null to include all elements with non-null values.
     *
     * @return Map The filtered collection.
     */
    public function filter($predicate = null)
    {
        $this->typeCheck->filter(func_get_args());

        if (null === $predicate) {
            $predicate = function ($key, $value) {
                return null !== $value;
            };
        }

        $result = $this->createMap();

        foreach ($this->elements as $element) {
            list($key, $value) = $element;
            if (call_user_func($predicate, $key, $value)) {
                $result->elements->pushBack($element);
            }
        }

        return $result;
    }

    /**
     * Produce a new collection by applying a transformation to each element.
     *
     * The new elements produced by the transform need not be of the same type.
     * It is not guaranteed that the concrete type of the resulting collection will match this collection.
     *
     * The transform must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return array($new_key, $new_value); }
     *
     * @param callable $transform The transform to apply to each element.
     *
     * @return IterableInterface A new collection produced by applying $transform to each element in this collection.
     */
    public function map($transform)
    {
        $this->typeCheck->map(func_get_args());

        $result = $this->createMap();

        foreach ($this->elements as $element) {
            list($key, $value) = call_user_func_array($transform, $element);
            $result->set($key, $value);
        }

        return $result;
    }

    /**
     * Partitions this collection into two collections according to a predicate.
     *
     * It is not guaranteed that the concrete type of the partitioned collections will match this collection.
     *
     * The predicate must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return $result; }
     *
     * @param callable $predicate A predicate function used to determine which partitioned collection to place the elements in.
     *
     * @return tuple<IterableInterface,IterableInterface> A 2-tuple containing the partitioned collections. The first collection contains the element for which the predicate returned true.
     */
    public function partition($predicate)
    {
        $this->typeCheck->partition(func_get_args());

        $left  = $this->createMap();
        $right = $this->createMap();

        foreach ($this->elements as $element) {
            if (call_user_func_array($predicate, $element)) {
                $left->elements->pushBack($element);
            } else {
                $right->elements->pushBack($element);
            }
        }

        return array($left, $right);
    }

    /**
     * Invokes the given callback on every element in the collection.
     *
     * This method behaves the same as {@see IterableInterface::map()} except that the return value of the callback is not retained.
     *
     * The callback must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { ... }
     *
     * @param callable $callback The callback to invoke with each element.
     */
    public function each($callback)
    {
        $this->typeCheck->each(func_get_args());

        $this->elements->each(
            function ($element) use ($callback) {
                return call_user_func_array($callback, $element);
            }
        );
    }

    /**
     * Returns true if the given predicate returns true for all elements.
     *
     * The loop is short-circuited, exiting after the first element for which the predicate returns false.
     *
     * The predicate must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return $result; }
     *
     * @param callable $predicate
     *
     * @return boolean True if $predicate($element) returns true for all elements; otherwise, false.
     */
    public function all($predicate)
    {
        $this->typeCheck->all(func_get_args());

        return $this->elements->all(
            function ($element) use ($predicate) {
                return call_user_func_array($predicate, $element);
            }
        );
    }

    /**
     * Returns true if the given predicate returns true for any element.
     *
     * The loop is short-circuited, exiting after the first element for which the predicate returns false.
     *
     * The predicate must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return $result; }
     *
     * @param callable $predicate
     *
     * @return boolean True if $predicate($element) returns true for any element; otherwise, false.
     */
    public function any($predicate)
    {
        $this->typeCheck->any(func_get_args());

        return $this->elements->any(
            function ($element) use ($predicate) {
                return call_user_func_array($predicate, $element);
            }
        );
    }

    ////////////////////////////////////////////////
    // Implementation of MutableIterableInterface //
    ////////////////////////////////////////////////

    /**
     * Filter this collection in-place.
     *
     * The predicate must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return $true_to_retain_element; }
     *
     * @param callable|null $predicate A predicate function used to determine which elements to retain, or null to retain all elements with non-null values.
     */
    public function filterInPlace($predicate = null)
    {
        $this->typeCheck->filterInPlace(func_get_args());

        if (null === $predicate) {
            $predicate = function ($key, $value) {
                return null !== $value;
            };
        }

        return $this->elements->filterInPlace(
            function ($element) use ($predicate) {
                return call_user_func_array($predicate, $element);
            }
        );
    }

    /**
     * Replace each element in the collection with the result of a transformation on that element.
     *
     * The new elements produced by the transform must be the same type.
     *
     * The transform must be a callable with the following signature:
     *  function (mixed $key, mixed $value) { return $new_value; }
     *
     * @param callable $transform The transform to apply to each element.
     */
    public function mapInPlace($transform)
    {
        $this->typeCheck->mapInPlace(func_get_args());

        foreach ($this->elements as $index => $element) {
            list($key, $value) = $element;
            $value = call_user_func($transform, $key, $value);
            $this->elements[$index] = array($key, $value);
        }
    }

    ////////////////////////////////////////////
    // Implementation of AssociativeInterface //
    ////////////////////////////////////////////

    /**
     * Check if the collection contains an element with the given key.
     *
     * @param mixed $key The key to check.
     *
     * @return boolean True if the collection contains the given key; otherwise, false.
     */
    public function hasKey($key)
    {
        $this->typeCheck->hasKey(func_get_args());

        return null !== $this->binarySearch($key);
    }

    /**
     * Fetch the value associated with the given key.
     *
     * @param mixed $key The key to fetch.
     *
     * @return mixed                         The associated value.
     * @throws Exception\UnknownKeyException if no such key exists.
     */
    public function get($key)
    {
        $this->typeCheck->get(func_get_args());

        $value = null;
        if ($this->tryGet($key, $value)) {
            return $value;
        }

        throw new Exception\UnknownKeyException($key);
    }

    /**
     * Fetch the value associated with the given key if it exists.
     *
     * @param mixed $key    The key to fetch.
     * @param mixed &$value Assigned the value associated with $key if it exists.
     *
     * @return boolean True if $key exists and $value was populated; otherwise, false.
     */
    public function tryGet($key, &$value)
    {
        $this->typeCheck->tryGet(func_get_args());

        $index = $this->binarySearch($key);

        if (null === $index) {
            return false;
        }

        list(, $value) = $this->elements[$index];

        return true;
    }

    /**
     * Fetch the value associated with the given key, or a default value if it does not exist.
     *
     * @param mixed $key     The key to fetch.
     * @param mixed $default The default value to return if $key does not exist.
     *
     * @return mixed The value associated with $key, or the $default if nos such key exists.
     */
    public function getWithDefault($key, $default = null)
    {
        $this->typeCheck->getWithDefault(func_get_args());

        $value = null;
        if ($this->tryGet($key, $value)) {
            return $value;
        }

        return $default;
    }

    /**
     * Return the value associated with the first key that exists.
     *
     * Takes a variable number of keys and searches for each one in order,
     * returns the value associated with the first key that exists.
     *
     * @param mixed $key            The key to search for.
     * @param mixed $additional,... Additional keys to search for.
     *
     * @return mixed                         The value associated with the first key that exists.
     * @throws Exception\UnknownKeyException if none of the keys exist.
     */
    public function cascade($key)
    {
        $this->typeCheck->cascade(func_get_args());

        return $this->cascadeIterable(func_get_args());
    }

    /**
     * Return the value associated with the first key that exists, or a default value if none of the provided keys exist.
     *
     * @param mixed $default        The default value to return if no such keys exist.
     * @param mixed $key            The key to search for.
     * @param mixed $additional,... Additional keys to search for.
     *
     * @return mixed The value associated with the first key that exists, or $default if none of the keys exist.
     */
    public function cascadeWithDefault($default, $key)
    {
        $this->typeCheck->cascadeWithDefault(func_get_args());

        $keys = func_get_args();
        $default = array_shift($keys);

        return $this->cascadeIterableWithDefault($default, $keys);
    }

    /**
     * Return the value associated with the first existing key in the given sequence.
     *
     * Behaves as per {@see Map::cascade()} except that the keys are provided as
     * a traversable (eg, array) instead of via a variable argument list.
     *
     * @param mixed<mixed> $keys The list of keys.
     *
     * @return mixed                         The value associated with the first key that exists.
     * @throws Exception\UnknownKeyException if none of the keys exist.
     */
    public function cascadeIterable($keys)
    {
        $this->typeCheck->cascadeIterable(func_get_args());

        $value = null;
        foreach ($keys as $key) {
            if ($this->tryGet($key, $value)) {
                return $value;
            }
        }

        throw new Exception\UnknownKeyException($key);
    }

    /**
     * Return the value associated with the first existing key in the given sequence, or a default value if none of the provided keys exist.
     *
     * Behaves as per {@see Map::cascadeDefault()} except that the keys are provided as
     * a traversable (eg, array) instead of via a variable argument list.
     *
     * @param mixed        $default The default value to return if no such keys exist.
     * @param mixed<mixed> $keys    The list of keys.
     *
     * @return mixed The value associated with the first key that exists, or $default if none of the keys exist.
     */
    public function cascadeIterableWithDefault($default, $keys)
    {
        $this->typeCheck->cascadeIterableWithDefault(func_get_args());

        $value = null;
        foreach ($keys as $key) {
            if ($this->tryGet($key, $value)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Fetch a native array containing the keys in the collection.
     *
     * There is no guarantee that the order of keys will match the order of values produced by {@see Map::values()}.
     *
     * @return array A native array containing the keys in the collection.
     */
    public function keys()
    {
        $this->typeCheck->keys(func_get_args());

        $keys = array();
        foreach ($this->elements as $element) {
            list($key, $value) = $element;
            $keys[] = $key;
        }

        return $keys;
    }

    /**
     * Fetch a native array containing the values in the collection.
     *
     * There is no guarantee that the order of values will match the order of keys produced by {@see Map::keys()}.
     *
     * @return array A native array containing the values in the collection.
     */
    public function values()
    {
        $this->typeCheck->values(func_get_args());

        $values = array();
        foreach ($this->elements as $element) {
            list($key, $value) = $element;
            $values[] = $value;
        }

        return $values;
    }

    /**
     * Produce a new collection containing the elements of this collection and one or more other collections.
     *
     * Any existing keys are overwritten from left to right.
     * It is not guaranteed that the concrete type of the merged collection will match this collection.
     *
     * @param AssociativeInterface $collection     The collection to combine.
     * @param AssociativeInterface $additional,... Additional collections to combine.
     *
     * @return AssociativeInterface The merged collection.
     */
    public function merge(AssociativeInterface $collection)
    {
        $this->typeCheck->merge(func_get_args());

        $result = clone $this;

        foreach (func_get_args() as $collection) {
            foreach ($collection->elements() as $element) {
                list($key, $value) = $element;
                $result->set($key, $value);
            }
        }

        return $result;
    }

    /**
     * Create a new collection containing the elements associated with the provided keys.
     *
     * It is not guaranteed that the concrete type of the projected collection will match this collection.
     *
     * @param mixed $key            The key to include in the new collection.
     * @param mixed $additional,... Ådditional keys to include in the new collection.
     *
     * @return AssociativeInterface The projection of the collection.
     */
    public function project($key)
    {
        $this->typeCheck->project(func_get_args());

        return $this->projectIterable(func_get_args());
    }

    /**
     * Create a new collection containing the elements associated with the provided keys.
     *
     * It is not guaranteed that the concrete type of the projected collection will match this collection.
     *
     * @param mixed<mixed> $keys The keys to include in the new collection.
     *
     * @return AssociativeInterface The projection of the collection.
     */
    public function projectIterable($keys)
    {
        $this->typeCheck->projectIterable(func_get_args());

        $result = $this->createMap();

        $value = null;
        foreach ($keys as $key) {
            if ($this->tryGet($key, $value)) {
                $result->set($key, $value);
            }
        }

        return $result;
    }

    ///////////////////////////////////////////////////
    // Implementation of MutableAssociativeInterface //
    ///////////////////////////////////////////////////

    /**
     * Associate a value with a key.
     *
     * Associates $value with $key regardless of whether or not $key already exists.
     *
     * @see Map::add()
     * @see Map::replace()
     *
     * @param mixed $key   The element's key.
     * @param mixed $value The element's value.
     */
    public function set($key, $value)
    {
        $this->typeCheck->set(func_get_args());

        $index = $this->binarySearch($key, 0, $insertIndex);

        if (null === $index) {
            $this->elements->insert(
                $insertIndex,
                array($key, $value)
            );
        } else {
            $this->elements[$index] = array($key, $value);
        }
    }

    /**
     * Associate a value with a new key.
     *
     * Associates $value with $key only if $key does not already exist.
     *
     * @see Map::set()
     * @see Map::replace()
     * @see Map::tryAdd()
     *
     * @param mixed $key   The element's key.
     * @param mixed $value The element's value.
     *
     * @throws Exception\DuplicateKeyException if $key already exists.
     */
    public function add($key, $value)
    {
        $this->typeCheck->add(func_get_args());

        if (!$this->tryAdd($key, $value)) {
            throw new Exception\DuplicateKeyException($key);
        }
    }

    /**
     * Associate a value with a new key.
     *
     * Associates $value with $key only if $key does not already exist.
     *
     * @see Map::add()
     *
     * @param mixed $key   The element's key.
     * @param mixed $value The element's value.
     *
     * @return boolean True if $key did not already exist and the value has been set; otherwise, false.
     */
    public function tryAdd($key, $value)
    {
        $this->typeCheck->tryAdd(func_get_args());

        if (null !== $this->binarySearch($key, 0, $insertIndex)) {
            return false;
        };

        $element = array($key, $value);
        $this->elements->insert($insertIndex, $element);

        return true;
    }

    /**
     * Associate a new value with an existing key.
     *
     * Associates $value with $key only if $key already exists.
     *
     * @see Map::add()
     * @see Map::set()
     * @see Map::tryReplace()
     *
     * @param mixed $key   The element's key.
     * @param mixed $value The element's value.
     *
     * @return mixed                         The value previously associated with this key.
     * @throws Exception\UnknownKeyException if $key does not already exist.
     */
    public function replace($key, $value)
    {
        $this->typeCheck->replace(func_get_args());

        $previous = null;
        if (!$this->tryReplace($key, $value, $previous)) {
            throw new Exception\UnknownKeyException($key);
        }

        return $previous;
    }

    /**
     * Associate a new value with an existing key.
     *
     * Associates $value with $key only if $key already exists.
     *
     * @see Map::replace()
     *
     * @param mixed $key       The element's key.
     * @param mixed $value     The element's value.
     * @param mixed &$previous Assigned the value previously associated with $key.
     *
     * @return boolean True if $key already exists and the new value has been set; otherwise, false.
     */
    public function tryReplace($key, $value, &$previous = null)
    {
        $this->typeCheck->tryReplace(func_get_args());

        $index = $this->binarySearch($key);

        if (null === $index) {
            return false;
        };

        list(, $previous) = $this->elements[$index];
        $this->elements[$index] = array($key, $value);

        return true;
    }

    /**
     * Remove an element from the collection.
     *
     * @param mixed $key The key of the element to remove.
     *
     * @return mixed                         The value associated with this key.
     * @throws Exception\UnknownKeyException if $key does not exist.
     */
    public function remove($key)
    {
        $this->typeCheck->remove(func_get_args());

        $value = null;
        if (!$this->tryRemove($key, $value)) {
            throw new Exception\UnknownKeyException($key);
        }

        return $value;
    }

    /**
     * Remove an element from the collection.
     *
     * @param mixed $key    The key of the element to remove.
     * @param mixed &$value Assigned the value associated with $key if it exists.
     *
     * @return boolean True if the key exists and has been removed; otherwise, false.
     */
    public function tryRemove($key, &$value = null)
    {
        $this->typeCheck->tryRemove(func_get_args());

        $index = $this->binarySearch($key);

        if (null === $index) {
            return false;
        }

        list(, $value) = $this->elements[$index];
        $this->elements->remove($index);

        return true;
    }

    /**
     * Add the elements from one or more other collections to this collection.
     *
     * Any existing keys are overwritten from left to right.
     *
     * @param AssociativeInterface $collection     The collection to merge.
     * @param AssociativeInterface $additional,... Additional collections to merge.
     */
    public function mergeInPlace(AssociativeInterface $collection)
    {
        $this->typeCheck->mergeInPlace(func_get_args());

        foreach (func_get_args() as $collection) {
            foreach ($collection->elements() as $element) {
                list($key, $value) = $element;
                $this->set($key, $value);
            }
        }
    }

    /**
     * Swap the elements associated with two keys.
     *
     * @param mixed $key1 The key of the first element.
     * @param mixed $key2 The key of the second element.
     *
     * @throws Exception\UnknownKeyException if $key1 or $key2 does not already exist.
     */
    public function swap($key1, $key2)
    {
        $this->typeCheck->swap(func_get_args());

        $index1 = $this->binarySearch($key1);
        $index2 = $this->binarySearch($key2);

        if (null === $index1) {
            throw new Exception\UnknownKeyException($key1);
        } elseif (null === $index2) {
            throw new Exception\UnknownKeyException($key2);
        }

        $temp = $this->elements[$index1][1];
        $this->elements[$index1] = array($key1, $this->elements[$index2][1]);
        $this->elements[$index2] = array($key2, $temp);
    }

    /**
     * Swap the elements associated with two keys.
     *
     * @param mixed $key1 The key of the first element.
     * @param mixed $key2 The key of the second element.
     *
     * @return boolean True if $key1 and $key2 exist and the swap is successful.
     */
    public function trySwap($key1, $key2)
    {
        $this->typeCheck->trySwap(func_get_args());

        $index1 = $this->binarySearch($key1);
        $index2 = $this->binarySearch($key2);

        if (null === $index1) {
            return false;
        } elseif (null === $index2) {
            return false;
        }

        $temp = $this->elements[$index1][1];
        $this->elements[$index1] = array($key1, $this->elements[$index2][1]);
        $this->elements[$index2] = array($key2, $temp);

        return true;
    }

    /**
     * Move an element from one key to another, replacing the target key if it already exists.
     *
     * @see Map::tryMove()
     * @see Map::rename()
     * @see Map::tryRename()
     *
     * @param mixed $source The existing key.
     * @param mixed $target The new key.
     *
     * @throws Exception\UnknownKeyException if $source does not already exist.
     */
    public function move($source, $target)
    {
        $this->typeCheck->move(func_get_args());

        if (!$this->tryMove($source, $target)) {
            throw new Exception\UnknownKeyException($source);
        }
    }

    /**
     * Move an element from one key to another, replacing the target key if it already exists.
     *
     * @see Map::move()
     * @see Map::rename()
     * @see Map::tryRename()
     *
     * @param mixed $source The existing key.
     * @param mixed $target The new key.
     *
     * @return boolean True if $source exists and the move is successful.
     */
    public function tryMove($source, $target)
    {
        $this->typeCheck->tryMove(func_get_args());

        $sourceIndex = $this->binarySearch($source);
        $targetIndex = $this->binarySearch($target, 0, $targetInsertIndex);

        if (null === $sourceIndex) {
            return false;
        } elseif ($sourceIndex === $targetIndex) {
            return true;
        }

        list(, $value) = $this->elements[$sourceIndex];

        $this->elements->remove($sourceIndex);

        if (null === $targetIndex) {
            if ($sourceIndex < $targetInsertIndex) {
                --$targetInsertIndex;
            }
            $this->elements->insert(
                $targetInsertIndex,
                array($target, $value)
            );
        } else {
            if ($sourceIndex < $targetInsertIndex) {
                --$targetIndex;
            }
            $this->elements[$targetIndex] = array($target, $value);
        }

        return true;
    }

    /**
     * Move an element from one key to another.
     *
     * It is an error if the target key already exists.
     *
     * @see Map::move()
     * @see Map::tryMove()
     * @see Map::tryRename()
     *
     * @param mixed $source The existing key.
     * @param mixed $target The new key.
     *
     * @throws Exception\UnknownKeyException   if $source does not already exist.
     * @throws Exception\DuplicateKeyException if $target already exists.
     */
    public function rename($source, $target)
    {
        $this->typeCheck->rename(func_get_args());

        $sourceIndex = $this->binarySearch($source);
        $targetIndex = $this->binarySearch($target, 0, $targetInsertIndex);

        if (null === $sourceIndex) {
            throw new Exception\UnknownKeyException($source);
        } elseif (null !== $targetIndex) {
            throw new Exception\DuplicateKeyException($target);
        }

        list(, $value) = $this->elements[$sourceIndex];

        $this->elements->remove($sourceIndex);

        if ($sourceIndex < $targetInsertIndex) {
            --$targetInsertIndex;
        }

        $this->elements->insert(
            $targetInsertIndex,
            array($target, $value)
        );
    }

    /**
     * Move an element from one key to another.
     *
     * It is an error if the target key already exists.
     *
     * @see Map::move()
     * @see Map::tryMove()
     * @see Map::rename()
     *
     * @param mixed $source The existing key.
     * @param mixed $target The new key.
     *
     * @return boolean True if $source exists, $target does not exist and the move is successful.
     */
    public function tryRename($source, $target)
    {
        $this->typeCheck->tryRename(func_get_args());

        $sourceIndex = $this->binarySearch($source);
        $targetIndex = $this->binarySearch($target, 0, $targetInsertIndex);

        if (null === $sourceIndex) {
            return false;
        } elseif (null !== $targetIndex) {
            return false;
        }

        list(, $value) = $this->elements[$sourceIndex];

        $this->elements->remove($sourceIndex);

        if ($sourceIndex < $targetInsertIndex) {
            --$targetInsertIndex;
        }

        $this->elements->insert(
            $targetInsertIndex,
            array($target, $value)
        );

        return true;
    }

    /////////////////////////////////
    // Implementation of Countable //
    /////////////////////////////////

    public function count()
    {
        $this->typeCheck->count(func_get_args());

        return $this->size();
    }

    /////////////////////////////////////////
    // Implementation of IteratorAggregate //
    /////////////////////////////////////////

    public function getIterator()
    {
        $this->typeCheck->getIterator(func_get_args());

        return new Iterator\UnpackIterator(
            $this->elements->getIterator()
        );
    }

    ///////////////////////////////////
    // Implementation of ArrayAccess //
    ///////////////////////////////////

    /**
     * Check if the collection contains an element with the given key.
     *
     * @param mixed $offset The key to check.
     *
     * @return boolean True if the collection contains the given key; otherwise, false.
     */
    public function offsetExists($offset)
    {
        $this->typeCheck->offsetExists(func_get_args());

        return $this->hasKey($offset);
    }

    /**
     * Fetch the value associated with the given key.
     *
     * @param mixed $offset The key to fetch.
     *
     * @return mixed                         The associated value.
     * @throws Exception\UnknownKeyException if no such key exists.
     */
    public function offsetGet($offset)
    {
        $this->typeCheck->offsetGet(func_get_args());

        return $this->get($offset);
    }

    /**
     * Associate a value with a key.
     *
     * Associates $value with $offset regardless of whether or not $key already exists.
     *
     * @param mixed $offset The element's key.
     * @param mixed $value  The element's value.
     */
    public function offsetSet($offset, $value)
    {
        $this->typeCheck->offsetSet(func_get_args());

        $this->set($offset, $value);
    }

    /**
     * Remove an element from the collection, if it is present.
     *
     * @param mixed $offset The key of the element to remove.
     */
    public function offsetUnset($offset)
    {
        $this->typeCheck->offsetUnset(func_get_args());

        $this->tryRemove($offset);
    }

    ////////////////////////////////////
    // Implementation of Serializable //
    ////////////////////////////////////

    /**
     * Serialize the collection.
     *
     * @return string The serialized data.
     */
    public function serialize()
    {
        $this->typeCheck->serialize(func_get_args());

        return serialize(
            array(
                $this->elements(),
                $this->comparator
            )
        );
    }

    /**
     * Unserialize collection data.
     *
     * @param string $packet The serialized data.
     */
    public function unserialize($packet)
    {
        TypeCheck::get(__CLASS__)->unserialize(func_get_args());

        list($elements, $comparator) = unserialize($packet);

        $this->__construct(null, $comparator);
        $this->elements->append($elements);
    }

    ///////////////////////////////////////////
    // Implementation of ComparableInterface //
    ///////////////////////////////////////////

    /**
     * Compare this object with another value, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param mixed $value The value to compare.
     *
     * @return integer                                         The result of the comparison.
     * @throws Icecave\Parity\Exception\NotComparableException Indicates that the implementation does not know how to compare $this to $value.
     */
    public function compare($value)
    {
        $this->typeCheck->compare(func_get_args());

        if (!$this->canCompare($value)) {
            throw new NotComparableException($this, $value);
        }

        return Collection::compare($this->elements, $value->elements);
    }

    /////////////////////////////////////////////////////
    // Implementation of RestrictedComparableInterface //
    /////////////////////////////////////////////////////

    /**
     * Check if $this is able to be compared to another value.
     *
     * A return value of false indicates that calling $this->compare($value)
     * will throw an exception.
     *
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this can be compared to $value.
     */
    public function canCompare($value)
    {
        $this->typeCheck->canCompare(func_get_args());

        return is_object($value)
            && __CLASS__ === get_class($value)
            && $this->comparator == $value->comparator;
    }

    ///////////////////////////////////////////////////
    // Implementation of ExtendedComparableInterface //
    ///////////////////////////////////////////////////

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this == $value.
     */
    public function isEqualTo($value)
    {
        $this->typeCheck->isEqualTo(func_get_args());

        return $this->compare($value) === 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this != $value.
     */
    public function isNotEqualTo($value)
    {
        $this->typeCheck->isNotEqualTo(func_get_args());

        return $this->compare($value) !== 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this < $value.
     */
    public function isLessThan($value)
    {
        $this->typeCheck->isLessThan(func_get_args());

        return $this->compare($value) < 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this > $value.
     */
    public function isGreaterThan($value)
    {
        $this->typeCheck->isGreaterThan(func_get_args());

        return $this->compare($value) > 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this <= $value.
     */
    public function isLessThanOrEqualTo($value)
    {
        $this->typeCheck->isLessThanOrEqualTo(func_get_args());

        return $this->compare($value) <= 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this >= $value.
     */
    public function isGreaterThanOrEqualTo($value)
    {
        $this->typeCheck->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($value) >= 0;
    }

    ////////////////////////////
    // Model specific methods //
    ////////////////////////////

    /**
     * @param mixed<mixed>|null $elements
     *
     * @return Map
     */
    private function createMap($elements = null)
    {
        return new self($elements, $this->comparator);
    }

    /**
     * @param mixed        $key
     * @param integer      $begin
     * @param integer|null &$insertIndex
     *
     * @return integer|null
     */
    private function binarySearch($key, $begin = 0, &$insertIndex = null)
    {
        $comparator = $this->comparator;

        return Collection::binarySearch(
            $this->elements,
            array($key, null),
            function ($lhs, $rhs) use ($comparator) {
                return call_user_func($comparator, $lhs[0], $rhs[0]);
            },
            $begin,
            null,
            $insertIndex
        );
    }

    private $typeCheck;
    private $comparator;
    private $elements;
}
