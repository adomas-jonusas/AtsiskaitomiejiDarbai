<?php
$a = 2;
$b = 3;

$out = [];

for ($i = 1; $i <= $a; $i++) {
    for ($j = 1; $j <= $b; $j++) {
        $out[] = $i . "*" . $j . " = " . ($i * $j);
    }
}

echo implode("; ", $out);
