<?php

/*
 * This file is part of the Falx PHP library.
 *
 * (c) Dan Homorodean <dan.homorodean@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Falx\DataStream\Generators\FillUtils;

use Falx\DataStream\Generators\Exception as GeneratorsException;

/**
 * Exception to be thrown when validation for range method fails.
 */
class RangeException extends GeneratorsException {

    /**
     * Creates and returns exception with suitable message for when an invalid 
     * step is passed as argument. 
     * @param int $step
     * @return RangeException
     */
    public static function invalidStepException($step) {
        return new self(sprintf('Invalid step %d', $step));
    }

    /**
     * Creates and returns exception with suitable message for when an invalid 
     * step is passed as argument. 
     * @param int $step
     * @return RangeException
     */
    public static function invalidSignedStepException($step) {
        $sign = $step < 0 ? 'negative' : 'positive';
        return new self(sprintf('Invalid %s step %d', $sign, $step));
    }

}
