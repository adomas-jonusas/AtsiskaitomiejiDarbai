<?php
$kaina = 150;
$lojalus_klientas = true;

if ($kaina > 100 && $lojalus_klientas) {
    $nuolaida = 0.20;
} elseif ($kaina > 100) {
    $nuolaida = 0.10;
} elseif ($lojalus_klientas) {
    $nuolaida = 0.05;
} else {
    $nuolaida = 0;
}

$galutine = $kaina * (1 - $nuolaida);
echo $galutine;
