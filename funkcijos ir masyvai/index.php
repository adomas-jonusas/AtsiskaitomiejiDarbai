<?php
$vardasPavarde = "Adomas Jonusas";
require "functions.php";

echo "<meta charset='utf-8'>";
echo "<div style='font-family:Arial'>";
echo "<h2>Užduotys su funkcijomis ir masyvais</h2>";
echo "<div><b>Vardas Pavardė:</b> " . htmlspecialchars($vardasPavarde) . "</div>";

echo "<h3>1 užduotis</h3>";
echo "<div>10 mi -> " . number_format(milesToKm(10), 2, ".", "") . " km</div>";
echo "<div>5 km -> " . number_format(kmToMiles(5), 2, ".", "") . " mi</div>";
echo "<div>1.5 h ir 80 km/h -> " . number_format(keliasIsLaikoIrGrecio(1.5, 80), 2, ".", "") . " km</div>";
echo "<div>300 K -> " . number_format(kelvinToCelsius(300), 2, ".", "") . " °C</div>";
echo "<div>2 A ir 230 V -> " . number_format(galiaIsSrovesIrItampos(2, 230), 2, ".", "") . " W</div>";
$cur = sroveIsVarzosIrItampos(50, 10);
echo "<div>50 Ω ir 10 V -> " . ($cur === null ? "negalima" : number_format($cur, 2, ".", "") . " A") . "</div>";
echo "<div>3 mi -> " . number_format(milesToKm(3), 2, ".", "") . " km</div>";
echo "<div>42 km -> " . number_format(kmToMiles(42), 2, ".", "") . " mi</div>";

echo "<h3>2 užduotis</h3>";

$preke1 = array(
    "pavadinimas" => "Sportinis gėrimas",
    "kaina" => 2.50,
    "paveiksliukas" => "https://picsum.photos/seed/p1/300/200",
    "kiekis" => 12,
    "aprasymas" => "Gaivus gėrimas po treniruotės.",
    "nuolaida" => 15
);

$preke2 = array(
    "pavadinimas" => "Baltymų batonėlis",
    "kaina" => 1.80,
    "paveiksliukas" => "https://picsum.photos/seed/p2/300/200",
    "kiekis" => 0,
    "aprasymas" => "Greitas užkandis su baltymais."
);

$preke3 = array(
    "pavadinimas" => "Gertuvė",
    "kaina" => 8.00,
    "paveiksliukas" => "https://picsum.photos/seed/p3/300/200",
    "kiekis" => 5,
    "aprasymas" => "Patogi gertuvė į sportą."
);

echo "<div style='margin-top:10px'><b>Pilnas išvedimas:</b></div>";
echo prekePilnai($preke1);
echo prekePilnai($preke2);

echo "<div style='margin-top:10px'><b>Katalogas:</b></div>";
echo prekeKatalogui($preke1);
echo prekeKatalogui($preke2);
echo prekeKatalogui($preke3);

echo "<h3>3 užduotis</h3>";
$prekes = array($preke1, $preke2, $preke3);
echo prekiuSarasas($prekes);

echo "</div>";
