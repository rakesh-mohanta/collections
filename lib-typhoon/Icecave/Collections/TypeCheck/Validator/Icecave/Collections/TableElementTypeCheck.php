<?php
namespace Icecave\Collections\TypeCheck\Validator\Icecave\Collections;

class TableElementTypeCheck extends \Icecave\Collections\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('table', 0, 'Icecave\\Collections\\Table');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('elements', 1, 'Icecave\\Collections\\MutableRandomAccessInterface');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('index', 2, 'integer');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'index',
                2,
                $arguments[2],
                'integer'
            );
        }
    }

    public function size(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function isEmpty(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function validateToString(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function clear(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function elements(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function contains(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function filtered(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        if ($argumentCount > 0) {
            $value = $arguments[0];
            if (!(\is_callable($value) || $value === null)) {
                throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'predicate',
                    0,
                    $arguments[0],
                    'callable|null'
                );
            }
        }
    }

    public function map(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('transform', 0, 'callable');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_callable($value)) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'transform',
                0,
                $arguments[0],
                'callable'
            );
        }
    }

    public function filter(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        if ($argumentCount > 0) {
            $value = $arguments[0];
            if (!(\is_callable($value) || $value === null)) {
                throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'predicate',
                    0,
                    $arguments[0],
                    'callable|null'
                );
            }
        }
    }

    public function apply(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('transform', 0, 'callable');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_callable($value)) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'transform',
                0,
                $arguments[0],
                'callable'
            );
        }
    }

    public function hasKey(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function get(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function tryGet(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function getWithDefault(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function cascade(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        }
    }

    public function cascadeWithDefault(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('default', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 1, 'mixed');
        }
    }

    public function cascadeIterable(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('keys', 0, 'mixed<mixed>');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        $check = function ($value) {
            if (!\is_array($value) && !$value instanceof \Traversable) {
                return false;
            }
            foreach ($value as $key => $subValue) {
            }
            return true;
        };
        if (!$check($arguments[0])) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'keys',
                0,
                $arguments[0],
                'mixed<mixed>'
            );
        }
    }

    public function cascadeIterableWithDefault(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('default', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('keys', 1, 'mixed<mixed>');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        $check = function ($value) {
            if (!\is_array($value) && !$value instanceof \Traversable) {
                return false;
            }
            foreach ($value as $key => $subValue) {
            }
            return true;
        };
        if (!$check($arguments[1])) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'keys',
                1,
                $arguments[1],
                'mixed<mixed>'
            );
        }
    }

    public function keys(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function values(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function combine(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('collection', 0, 'Icecave\\Collections\\AssociativeInterface');
        }
        if ($argumentCount > 1) {
            $check = function ($argument, $index) {
                $value = $argument;
                if (!$value instanceof \Icecave\Collections\AssociativeInterface) {
                    throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                        'additional',
                        $index,
                        $argument,
                        'Icecave\\Collections\\AssociativeInterface'
                    );
                }
            };
            for ($index = 1; $index < $argumentCount; $index++) {
                $check($arguments[$index], $index);
            }
        }
    }

    public function project(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        }
    }

    public function projectIterable(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('keys', 0, 'mixed<mixed>');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        $check = function ($value) {
            if (!\is_array($value) && !$value instanceof \Traversable) {
                return false;
            }
            foreach ($value as $key => $subValue) {
            }
            return true;
        };
        if (!$check($arguments[0])) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                'keys',
                0,
                $arguments[0],
                'mixed<mixed>'
            );
        }
    }

    public function set(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function add(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function tryAdd(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function replace(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function tryReplace(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

    public function remove(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function tryRemove(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key', 0, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function merge(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('collection', 0, 'Icecave\\Collections\\AssociativeInterface');
        }
        if ($argumentCount > 1) {
            $check = function ($argument, $index) {
                $value = $argument;
                if (!$value instanceof \Icecave\Collections\AssociativeInterface) {
                    throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentValueException(
                        'additional',
                        $index,
                        $argument,
                        'Icecave\\Collections\\AssociativeInterface'
                    );
                }
            };
            for ($index = 1; $index < $argumentCount; $index++) {
                $check($arguments[$index], $index);
            }
        }
    }

    public function swap(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key1', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key2', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function trySwap(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key1', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('key2', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function move(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('source', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('target', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function tryMove(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('source', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('target', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function rename(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('source', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('target', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function tryRename(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('source', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('target', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function count(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function current(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function key(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function next(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function rewind(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function valid(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function offsetExists(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('offset', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function offsetGet(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('offset', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function offsetSet(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('offset', 0, 'mixed');
            }
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('value', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function offsetUnset(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\MissingArgumentException('offset', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function table(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Collections\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
