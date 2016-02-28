<?php

/*
 * This file is part of the Falx PHP library.
 *
 * (c) Dan Homorodean <dan.homorodean@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Falx\DataStream\Generators\TraverseUtils;

use Falx\DataStream\Generators\Exception as GeneratorsException;

/**
 * Exception to be thrown when validation for map method fails.
 */
class MapException extends GeneratorsException {

    /**
     * Creates and returns exception for the case when no generator is passed.
     * 
     * @return MapException
     */
    public static function noGeneratorsException() {
        return new self('At least one Generator instance must be provided as second argument');
    }

    /**
     * Creates and returns exception for the cases when something other than a 
     * generator instance is passed.
     * 
     * @param int $number
     * @return MapException
     */
    public static function expectedGeneratorArgument($number) {
        return new self(sprintf('Expected Generator instance for argument number %d', $number));
    }

}
