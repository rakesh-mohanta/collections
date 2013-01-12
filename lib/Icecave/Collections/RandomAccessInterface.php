<?php
namespace Icecave\Collections;

/**
 * A random access sequence is a sequence that provides access to elements by their position in the sequence.
 */
interface RandomAccessInterface extends SequenceInterface
{
    /**
     * Fetch the element at the given index.
     *
     * @param mixed $index The index of the element to fetch, if index is a negative number the element that far from the end of the sequence is returned.
     *
     * @return mixed                    The element at $index.
     * @throws Exception\IndexException if no such index exists.
     */
    public function get($index);

    /**
     * Extract a range of elements.
     *
     * It is not guaranteed that the concrete type of the slice collection will match this collection.
     *
     * @param integer      $index The index from which the slice will start. If index is a negative number the slice will begin that far from the end of the sequence.
     * @param integer|null $count The maximum number of elements to include in the slice, or null to include all elements from $index to the end of the sequence.
     *
     * @return SequenceInterface        The sliced sequence.
     * @throws Exception\IndexException if $index is out of range.
     */
    public function slice($index, $count = null);

    /**
     * Extract a range of elements.
     *
     * It is not guaranteed that the concrete type of the slice collection will match this collection.
     *
     * Extracts all elements in the range [$begin, $end), i.e. $begin is inclusive, $end is exclusive.
     *
     * @param integer $begin The index from which the slice will start. If begin is a negative number the slice will begin that far from the end of the sequence.
     * @param integer $end   The index at which the slice will end. If end is a negative number the slice will end that far from the end of the sequence.
     *
     * @return SequenceInterface        The sliced sequence.
     * @throws Exception\IndexException if $index is out of range.
     */
    public function range($begin, $end);

    /**
     * Find the index of the first instance of a particular element in the sequence.
     *
     * @param mixed   $element    The element to search for.
     * @param integer $startIndex The index to start searching from.
     *
     * @return integer|null The index of the element, or null if is not present in the sequence.
     */
    public function indexOf($element, $startIndex = 0);

    /**
     * Find the index of the last instance of a particular element in the sequence.
     *
     * @param mixed        $element    The element to search for.
     * @param integer|null $startIndex The index to start searching from, or null to use the last index.
     *
     * @return integer|null The index of the element, or null if is not present in the sequence.
     */
    public function indexOfLast($element, $startIndex = null);

    /**
     * Find the index of the first instance of an element matching given criteria.
     *
     * @param callable $predicate  A predicate function used to determine which element constitutes a match.
     * @param integer  $startIndex The index to start searching from.
     *
     * @return integer|null The index of the element, or null if is not present in the sequence.
     */
    public function find($predicate, $startIndex = 0);

    /**
     * Find the index of the last instance of an element matching given criteria.
     *
     * @param callable     $predicate  A predicate function used to determine which element constitutes a match.
     * @param integer|null $startIndex The index to start searching from, or null to use the last index.
     *
     * @return integer|null The index of the element, or null if is not present in the sequence.
     */
    public function findLast($predicate, $startIndex = null);
}
