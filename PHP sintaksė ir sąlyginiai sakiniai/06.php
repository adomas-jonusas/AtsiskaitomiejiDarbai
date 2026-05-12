<?php
$temperatura = 18;
$lyja = false;

if ($temperatura > 15 && !$lyja) {
    echo "Tinkama eiti pasivaikščioti";
} elseif ($temperatura <= 15 || $lyja) {
    echo "Geriau likti namuose";
} else {
    echo "Apsirenkite pagal orą";
}
