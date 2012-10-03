<?php
namespace Icecave\Collections;

use Icecave\Collections\Support\Stringify;
use SplPriorityQueue;

/**
 * A prioritized queue.
 *
 * Higher priority values are moved closer to the front of the queue.
 *
 * Prioritization is provided by the prioritzation function specified in the constructor, but may
 * be optionally overridden by the second parameter to {@see PriorityQueue::push()}.
 */
class PriorityQueue extends Queue
{
    /**
     * @param callable $ranker A function used to generate the priority for a given element.
     * @param traversable|null $collection An iterable type containing the elements to include in this list, or null to create an empty list.
     */
    public function __construct($prioritizer, $collection = null)
    {
        $this->prioritizer = $prioritizer;
        parent::__construct($collection);
    }

    ///////////////////////////////////
    // Implementation of ICollection //
    ///////////////////////////////////

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
            return '<PriorityQueue 0>';
        }

        return sprintf(
            '<PriorityQueue %d [next: %s]>',
            $this->size(),
            Stringify::stringify($this->next())
        );
    }

    //////////////////////////////////////////
    // Implementation of IMutableCollection //
    //////////////////////////////////////////

    /**
     * Remove all elements from the collection.
     */
    public function clear()
    {
        $this->elements = new SplPriorityQueue;
    }

    /////////////////////////////////////
    // Implementation of IQueuedAccess //
    /////////////////////////////////////

    /**
     * Fetch the element at the front of the queue.
     *
     * @return mixed The element at the front of the queue.
     * @throws Exception\EmptyCollectionException if the collection is empty.
     */
    public function next()
    {
        if ($this->isEmpty()) {
            throw new Exception\EmptyCollectionException;
        }

        return $this->elements->top();
    }

    /**
     * Add a new element to the end of the queue.
     *
     * @param mixed $element The element to add.
     * @param integer|null $priority The priority of the element being added, or NULL to use the queue's prioritizer.
     */
    public function push($element, $priority = null)
    {
        if (null == $priority) {
            $priority = call_user_func($this->prioritizer, $element);
        }

        $this->elements->insert($element, $priority);
    }

    /**
     * Remove and return the element at the front of the queue.
     *
     * @return mixed The element at the front of the sequence.
     * @throws Exception\EmptyCollectionException if the collection is empty.
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new Exception\EmptyCollectionException;
        }

        return $this->elements->extract();
    }
}
