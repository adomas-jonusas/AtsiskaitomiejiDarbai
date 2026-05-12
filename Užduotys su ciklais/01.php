<?php
$menesiai = ["Sausis","Vasaris","Kovas","Balandis","Gegužė","Birželis","Liepa","Rugpjūtis","Rugsėjis","Spalis","Lapkritis","Gruodis"];

for ($i = 0; $i < count($menesiai); $i++) {
    echo $menesiai[$i];
    if ($i < count($menesiai) - 1) echo "\n";
}
