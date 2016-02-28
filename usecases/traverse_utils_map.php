<?php

require 'config.php';;

use Falx\DataStream\Generators\FillUtils;
use Falx\DataStream\Generators\TraverseUtils;


// Happy flow, it uses the maximum commom count of generated values for all generators
$bases = FillUtils::range(1, 5);
$exps = FillUtils::range(1, 10);

$callback = function($base,$exp) {
    return pow($base,$exp);
};
// It returns generator with 5 numbers 1 to 5 raised to powers 1 to 5 
$powered = TraverseUtils::map($callback, $bases, $exps);
foreach ($powered as $number) {
    print $number . PHP_EOL;
}




// One empty generator test
$bases = FillUtils::range(1, 2);
$expsf = function(){
  return;
  yield 0;
};
$exps = $expsf();

$callback = function($base,$exp) {
    return pow($base,$exp);
};

// It return empty generator due to one empty generator as argument
$powered = TraverseUtils::map($callback, $bases, $exps);

foreach ($powered as $number) {
    print $number . PHP_EOL;
}

