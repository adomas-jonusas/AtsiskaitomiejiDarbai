<?php
$x = 120;

if ($x < 0) {
    echo "Skaičius neigiamas";
} elseif ($x >= 0 && $x <= 100) {
    echo "Skaičius tarp 0 ir 100";
} else {
    echo "Skaičius didesnis nei 100";
}
