<?php
namespace Icecave\Collections;

// @codeCoverageIgnoreStart

/**
 * An associative collection is a variable-sized collection that supports efficient retrieval of values based on keys.
 *
 * Each element in an associative collection is a 2-tuple of key and value.
 */
interface IAssociative extends IIterable {

    /**
     * Check if the collection contains an element with the given key.
     *
     * @param mixed $key The key to check.
     *
     * @return boolean true if the collection contains the given key; otherwise, false.
     */
    public function hasKey($key);

    /**
     * Fetch the value associated with the given key.
     *
     * @param mixed $key The key to fetch.
     *
     * @return mixed The associated value.
     * @throws Exception\UnknownKeyError Thrown if no such key exists.
     */
    public function get($key);

    /**
     * Fetch the value associated with the given key if it exists.
     *
     * @param mixed $key The key to fetch.
     * @param mixed &$value Assigned the value associated with $key if it exists.
     *
     * @return boolean true if $key exists and $value was populated; otherwise, false.
     */
    public function tryGet($key, &$value);

    /**
     * Fetch the value associated with the given key, or a default value if it does not exist.
     *
     * @param mixed $key The key to fetch.
     * @param mixed $default The default value to return if $key does not exist.
     *
     * @return mixed The value associated with $key, or the $default if nos such key exists.
     */
    public function getDefault($key, $default = null);

    /**
     * Return the value associated with the first key that exists.
     *
     * Takes a variable number of keys and searches for each one in order,
     * returns the value associated with the first key that exists.
     *
     * @param mixed,... $key The keys to search for.
     *
     * @return mixed The value associated with the first key that exists.
     * @throws Exception\UnknownKeyError Thrown if none of the keys exist.
     */
    public function getCascade($key);

    /**
     * Return the value associated with the first key that exists, or a default value if none of the provided keys exist.
     *
     * @param mixed,... $key The keys to search for.
     * @param mixed $default The default value to return if no such keys exist.
     *
     * @return mixed The value associated with the first key that exists, or $default if none of the keys exist.
     */
    public function getCascadeDefault($key, $default = null);

    /**
     * Return the value associated with the first existing key in the given sequence.
     *
     * Behaves as per {@see IAssociative::cascade()} except that the keys are provided as
     * a traversible (eg, array) instead of via a variable argument list.
     *
     * @param traversable $keys The list of keys.
     *
     * @return mixed The value associated with the first key that exists.
     * @throws Exception\UnknownKeyError Thrown if none of the keys exist.
     */
    public function getCascadeSeq($keys);

    /**
     * Return the value associated with the first existing key in the given sequence, or a default value if none of the provided keys exist.
     *
     * Behaves as per {@see IAssociative::cascadeDefault()} except that the keys are provided as
     * a traversible (eg, array) instead of via a variable argument list.
     *
     * @param traversable $keys The list of keys.
     * @param mixed $default The default value to return if no such keys exist.
     *
     * @return mixed The value associated with the first key that exists, or $default if none of the keys exist.
     */
    public function getCascadeSeqDefault($keys, $default = null);

    /**
     * Fetch a native array containing the keys in the collection.
     *
     * There is no guarantee that the order of keys will match the order of values produced by {@see IAssociative::values()}.
     *
     * @return array A native array containing the keys in the collection.
     */
    public function keys();

    /**
     * Fetch a native array containing the values in the collection.
     *
     * There is no guarantee that the order of values will match the order of keys produced by {@see IAssociative::keys()}.
     *
     * @return array A native array containing the values in the collection.
     */
    public function values();

    /**
     * Produce a new collection containing the elements of this collection and one or more other collections.
     *
     * Any existing keys are overwritten from left to right.
     * It is not guaranteed that the concrete type of the merged collection will match this collection.
     *
     * @param IAssociative,... $collection The collections to combine.
     *
     * @return IAssociative The merged collection.
     */
    public function combine(IAssociative $collection);

    /**
     * Create a new collection containing the elements associated with the provided keys.
     *
     * It is not guaranteed that the concrete type of the projected collection will match this collection.
     *
     * @param mixed,... $key The keys to include in the new collection.
     *
     * @return IAssociative The projection of the collection.
     */
    public function project($key);

    /**
     * Create a new collection containing the elements associated with the provided keys.
     *
     * It is not guaranteed that the concrete type of the projected collection will match this collection.
     *
     * @param traversable $keys The keys to include in the new collection.
     *
     * @return IAssociative The projection of the collection.
     */
    public function projectSeq($keys);
}
