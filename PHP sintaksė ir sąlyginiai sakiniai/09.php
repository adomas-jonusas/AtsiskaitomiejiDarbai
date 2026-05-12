<?php
$amzius = 23;
$vairavimo_stazas = 2;

if ($amzius >= 25 && $vairavimo_stazas >= 3) {
    echo "Nuoma leidžiama";
} elseif ($amzius >= 21 && $vairavimo_stazas >= 1) {
    echo "Nuoma leidžiama su papildomu mokesčiu";
} else {
    echo "Nuoma neleidžiama";
}
