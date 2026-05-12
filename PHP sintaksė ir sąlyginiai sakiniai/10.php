<?php
$sunaudota_kwh = 250;

if ($sunaudota_kwh <= 100) {
    $tarifas = 0.15;
} elseif ($sunaudota_kwh <= 300) {
    $tarifas = 0.20;
} else {
    $tarifas = 0.25;
}

$mokestis = $sunaudota_kwh * $tarifas;
echo $mokestis;
