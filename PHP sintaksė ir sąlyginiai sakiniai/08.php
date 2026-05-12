<?php
$tasku_skaicius = 60;
$nepazeide_taisykliu = true;

if ($tasku_skaicius >= 50 && $nepazeide_taisykliu) {
    echo "Egzaminas išlaikytas";
} elseif ($tasku_skaicius >= 50 && !$nepazeide_taisykliu) {
    echo "Neišlaikyta dėl pažeidimų";
} else {
    echo "Egzaminas neišlaikytas";
}
