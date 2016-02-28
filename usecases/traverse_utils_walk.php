<?php

require 'config.php';

use Falx\DataStream\Generators\FillUtils;
use Falx\DataStream\Generators\TraverseUtils;

$elements = FillUtils::range(1, 10);
$callback = function($value, $key, $userData) {
    print $value . ' at key ' . $key . $userData . PHP_EOL;
};
TraverseUtils::walk($elements, $callback, ' !!! ');


