<?php

require 'config.php';

use Falx\DataStream\Generators\FillUtils;

// Simple range usage
$elements = FillUtils::range(1, 10);
foreach ($elements as $elem) {
    print $elem . PHP_EOL;
}

// With bigger step
$elements = FillUtils::range(1, 10);
foreach ($elements as $elem) {
    print $elem . PHP_EOL;
}

// Descending
$elements = FillUtils::range(10, 1, -2);
foreach ($elements as $elem) {
    print $elem . PHP_EOL;
}

// Memory consumption
$before = memory_get_usage(true);
$generator = FillUtils::range(1, 10000000);
print 'GENERATOR: ' . (memory_get_usage(true) - $before) . PHP_EOL;

$before = memory_get_usage(true);
$array = range(1, 10000000);
print 'RANGE: ' . (memory_get_usage(true) - $before) . PHP_EOL;
