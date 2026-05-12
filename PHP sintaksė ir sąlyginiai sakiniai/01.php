<?php
$vartotojas = "admin";
$slaptazodis = "1234";

if ($vartotojas === "admin" && $slaptazodis === "1234") {
    echo "Prisijungimas sėkmingas";
} elseif ($vartotojas === "admin" || $slaptazodis === "1234") {
    echo "Neteisingi prisijungimo duomenys";
} else {
    echo "Prieiga draudžiama";
}
