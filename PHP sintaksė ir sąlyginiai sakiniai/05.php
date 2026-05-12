<?php
$valandos = 45;
$valandinis_atlygis = 10;

if ($valandos <= 40) {
    $atlygis = $valandos * $valandinis_atlygis;
} else {
    $atlygis = (40 * $valandinis_atlygis) + 
               (($valandos - 40) * $valandinis_atlygis * 1.5);
}

echo $atlygis;
