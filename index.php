<?php

require_once __DIR__ . '/sequence.php';

$input    = [ 9, 73, 241, 561, 1081, 1849 ];
$extendBy = 2;
$extender = new extender();
$result   = $extender->proceed($input, $extendBy);

echo "<pre>";
var_dump("RESULT:", $input, $result);
