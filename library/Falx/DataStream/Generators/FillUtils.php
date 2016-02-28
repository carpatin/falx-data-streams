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

use Falx\DataStream\Generators\FillUtils\RangeException;

/**
 * Utility methods for building (filling) generators.
 * 
 * @author Dan Homorodean <dan.homorodean@gmail.com>
 */
class FillUtils {

    /**
     * Range implementation using generator, suitable for generating large 
     * ranges of integers.
     * It generates both ascending and descenting ranges, depending on the start 
     * and end arguments.
     * 
     * @param int $start 
     * @param int $end
     * @param int $step Negative or positive step. Cannot be 0.
     * @throws \Exception
     */
    public static function range($start, $end, $step = 1) {
        if ($step === 0) {
            throw RangeException::invalidStepException(0);
        }

        if ($start < $end && $step < 0) {
            throw RangeException::invalidSignedStepException($step);
        }

        if ($start > $end && $step > 0) {
            throw RangeException::invalidSignedStepException($step);
        }

        if ($start < $end) {
            for ($i = $start; $i <= $end; $i+=$step) {
                yield $i;
            }
        } else {
            for ($i = $start; $i >= $end; $i+=$step) {
                yield $i;
            }
        }
    }

}
