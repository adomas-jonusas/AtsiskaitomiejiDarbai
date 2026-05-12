<?php
$pazymys = 8;
$lankomumas = 90;

if ($pazymys >= 8 && $lankomumas >= 90) {
    echo "Puikūs rezultatai";
} elseif ($pazymys >= 5 && $lankomumas >= 75) {
    echo "Rezultatai patenkinami";
} else {
    echo "Rezultatai blogi";
}
