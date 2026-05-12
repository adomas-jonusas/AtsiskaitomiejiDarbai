<?php
$n = 6;

if ($n < 0) {
    echo "Faktorialas neskaičiuojamas neigiamam skaičiui";
    exit;
}

if ($n === 0 || $n === 1) {
    echo $n . "! = 1 = 1";
    exit;
}

$rez = 1;
$parts = [];

for ($i = $n; $i >= 1; $i--) {
    $rez *= $i;
    $parts[] = (string)$i;
}

echo $n . "! = " . implode("*", $parts) . " = " . $rez;
