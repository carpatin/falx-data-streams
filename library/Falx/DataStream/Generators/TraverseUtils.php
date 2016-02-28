<?php

/*
 * This file is part of the Falx PHP library.
 *
 * (c) Dan Homorodean <dan.homorodean@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Falx\DataStream\Generators;

use Falx\DataStream\Generators\TraverseUtils\MapException;

/**
 * Util methods for traversing Generators.
 * 
 * @author Dan Homorodean <dan.homorodean@gmail.com>
 */
class TraverseUtils {
    /* ==============================================================
      GENERATOR MAP
      =============================================================== */

    /**
     * Calls the given callable on each tuple of elements from the passes 
     * generators, starting with the second argument. At least one generator 
     * needs to be passed in order to return something.
     * 
     * Precondition is that all arguments starting with the second one are 
     * generators.
     * 
     * Postcondition is that this method is also a generator, returning a 
     * Generator instance on call.
     * 
     * @param callable $callback
     * @return void In case one of provided generators is empty
     * @yield mixed Current callback mapped element
     * @throws MapException
     */
    public static function map(callable $callback) {

        $numArgs = func_num_args();
        if ($numArgs == 1) {
            throw MapException::noGeneratorsException();
        }

        $generators = [];
        for ($i = 1; $i < $numArgs; $i++) {
            $argument = func_get_arg($i);
            if (!$argument instanceof \Generator) {
                throw MapException::expectedGeneratorArgument($i);
            }
            $generators[] = $argument;
        }

        // Check that all generators have at least one value
        if (!self::validAll($generators)) {
            return;
        }

        // Iterate values in generators at the same time and call map function on them
        do {
            $callArguments = self::currentAll($generators);
            yield call_user_func_array($callback, $callArguments);
            self::nextAll($generators);
            $valid = self::validAll($generators);
        } while ($valid);
    }

    /**
     * Calls valid() on all generators in passed array.
     * Returns whether all calls returned true, false if at least one of them is 
     * not valid.
     * Precondition is that the array contains only Generator instances.
     * 
     * @param array $generators
     * @return boolean
     */
    private static function validAll(array $generators) {
        foreach ($generators as $generator) {
            if (!$generator->valid()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Calls next() on all generators in passed array.
     * Precondition is that the array contains only Generator instances.
     * 
     * @param array $generators
     */
    private static function nextAll(array $generators) {
        foreach ($generators as $generator) {
            $generator->next();
        }
    }

    /**
     * Cals current on all generators passed and collects return values in an 
     * array, which it returns.
     * Precondition is that the array contains only Generator instances.
     * 
     * @param array $generators
     * @return array
     */
    private static function currentAll(array $generators) {
        $currentAll = [];
        foreach ($generators as $generator) {
            $currentAll[] = $generator->current();
        }

        return $currentAll;
    }

    /* ==============================================================
      GENERATOR FILTER
      =============================================================== */

    const FILTER_USE_VALUE = 0;
    const FILTER_USE_KEY = 1;
    const FILTER_USE_BOTH = 2;

    /**
     * Filters a generator.
     * This is also implemented as a generator.
     * 
     * @param \Generator $generator
     * @param callable $callback
     * @param boolean $flag
     * @yield mixed Current filtered element
     */
    public static function filter(\Generator $generator, callable $callback = null, $flag = self::FILTER_USE_VALUE) {
        // Check for provided callback
        if ($callback === null) {
            $callback = function($value) {
                return !empty($value);
            };
        }

        // Filter each element in array, and yield the ones that comply
        $passes = false;
        foreach ($generator as $key => $value) {
            switch ($flag) {
                case self::FILTER_USE_VALUE:
                    $passes = $callback($value);
                    break;
                case self::FILTER_USE_KEY:
                    $passes = $callback($key);
                    break;
                case self::FILTER_USE_BOTH:
                    $passes = $callback($key, $value);
                    break;
            }
            if ($passes) {
                yield $key => $value;
            }
        }
    }

    /* ==============================================================
      GENERATOR WALK
      =============================================================== */

    /**
     * Walks a Generator, calling the passed callback on each of its elements.
     * 
     * @param \Generator $generator
     * @param callable $callback
     * @param mixed $data Optional, user provided data that is passed to callback 
     * as third parameter.
     */
    public static function walk(\Generator $generator, callable $callback, $data = null) {

        foreach ($generator as $key => $value) {
            if ($data !== null) {
                $callback($value, $key, $data);
            } else {
                $callback($value, $key);
            }
        }
    }

}
