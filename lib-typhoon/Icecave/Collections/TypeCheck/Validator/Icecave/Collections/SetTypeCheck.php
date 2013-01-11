<?php
namespace Icecave\Collections\TypeCheck\Validator\Icecave\Collections;


class SetTypeCheck extends \Icecave\Collections\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount > 2))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]));
        }
        if (($argumentCount > 0))
        {
            ($value = $arguments[0]);
            ($check =             function ($value)
                        {
                            ($check =                 function ($value)
                                            {
                                                if (((!\is_array($value)) && (!($value instanceof \Traversable))))
                                                {
                                                    return false;
                                                }
                                                foreach ($value as $key => $subValue)
                                                {
                                                }
                                                return true;
                                            }
                            );
                            if (                function ($value)
                                            {
                                                if (((!\is_array($value)) && (!($value instanceof \Traversable))))
                                                {
                                                    return false;
                                                }
                                                foreach ($value as $key => $subValue)
                                                {
                                                }
                                                return true;
                                            }
                            )
                            {
                                return true;
                            }
                            return ($value === null);
                        }
            );
            if ((!$check($arguments[0])))
            {
                throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'collection',
                    0,
                    $arguments[0],
                    'mixed<mixed>|null'
                ));
            }
        }
        if (($argumentCount > 1))
        {
            ($value = $arguments[1]);
            if ((!(\is_callable($value) || ($value === null))))
            {
                throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hashFunction',
                    1,
                    $arguments[1],
                    'callable|null'
                ));
            }
        }
    }
    public function size(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function isEmpty(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function validateToString(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function clear(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function elements(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function contains(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function filtered(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        if (($argumentCount > 0))
        {
            ($value = $arguments[0]);
            if ((!(\is_callable($value) || ($value === null))))
            {
                throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'predicate',
                    0,
                    $arguments[0],
                    'callable|null'
                ));
            }
        }
    }
    public function map(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('transform', 0, 'callable'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_callable($value)))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'transform',
                0,
                $arguments[0],
                'callable'
            ));
        }
    }
    public function filter(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        if (($argumentCount > 0))
        {
            ($value = $arguments[0]);
            if ((!(\is_callable($value) || ($value === null))))
            {
                throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'predicate',
                    0,
                    $arguments[0],
                    'callable|null'
                ));
            }
        }
    }
    public function apply(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('transform', 0, 'callable'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_callable($value)))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'transform',
                0,
                $arguments[0],
                'callable'
            ));
        }
    }
    public function count(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function current(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function key(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function next(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function rewind(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function valid(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function cascade(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('element', 0, 'mixed'));
        }
    }
    public function cascadeWithDefault(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 2))
        {
            if (($argumentCount < 1))
            {
                throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('default', 0, 'mixed'));
            }
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('element', 1, 'mixed'));
        }
    }
    public function cascadeIterable(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed<mixed>'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        ($check =         function ($value)
                {
                    if (((!\is_array($value)) && (!($value instanceof \Traversable))))
                    {
                        return false;
                    }
                    foreach ($value as $key => $subValue)
                    {
                    }
                    return true;
                }
        );
        if ((!$check($arguments[0])))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'elements',
                0,
                $arguments[0],
                'mixed<mixed>'
            ));
        }
    }
    public function cascadeIterableWithDefault(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 2))
        {
            if (($argumentCount < 1))
            {
                throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('default', 0, 'mixed'));
            }
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 1, 'mixed<mixed>'));
        }
        elseif (($argumentCount > 2))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]));
        }
        ($value = $arguments[1]);
        ($check =         function ($value)
                {
                    if (((!\is_array($value)) && (!($value instanceof \Traversable))))
                    {
                        return false;
                    }
                    foreach ($value as $key => $subValue)
                    {
                    }
                    return true;
                }
        );
        if ((!$check($arguments[1])))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'elements',
                1,
                $arguments[1],
                'mixed<mixed>'
            ));
        }
    }
    public function add(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('element', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function remove(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('element', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function union(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function unionInPlace(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function intersect(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function intersectInPlace(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function complement(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function complementInPlace(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
    public function generateHash(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
    }
}