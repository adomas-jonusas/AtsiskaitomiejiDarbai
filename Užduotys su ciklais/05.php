<?php
for ($n = 1; $n <= 20; $n++) {
    $suma = 0;
    $eilute = "1";

    for ($i = 1; $i <= $n; $i++) {
        $suma += $i;
        if ($i === 1) {
            $eilute = "1";
        } else {
            $eilute .= "+" . $i;
        }
    }

    echo $n . ": " . $eilute . "=" . $suma;
    if ($n < 20) echo "\n\n";
}
