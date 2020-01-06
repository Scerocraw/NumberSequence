<?php

require_once __DIR__ . '/sequence.php';

// Controls the input / sequence to extend
$input    = [ 9, 73, 241, 561, 1081, 1849 ];

// By how many numbers the sequence should be extended
$extendBy = 2;

// Stuff
$extender = new extender();
$result   = $extender->proceed($input, $extendBy);

// Output
echo "<pre>";
var_dump("RESULT:", $input, $result);
