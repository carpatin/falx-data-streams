<?php

require 'config.php';

use Falx\DataStream\Generators\FillUtils;
use Falx\DataStream\Generators\TraverseUtils;

$elements = FillUtils::range(1, 10000);

// Odd number filter callback
$callback = function($value) {
    return $value % 2 == 1;
};

$odd = TraverseUtils::filter($elements, $callback);

foreach ($odd as $number) {
    print $number . PHP_EOL;
}



