<?php
function milesToKm($miles) {
    return $miles * 1.609344;
}
function kmToMiles($km) {
    return $km / 1.609344;
}
function keliasIsLaikoIrGrecio($laikasVal, $greitisKmh) {
    return $laikasVal * $greitisKmh;
}
function kelvinToCelsius($k) {
    return $k - 273.15;
}
function galiaIsSrovesIrItampos($sroveA, $itampaV) {
    return $sroveA * $itampaV;
}
function sroveIsVarzosIrItampos($varzaOhm, $itampaV) {
    if ($varzaOhm == 0) return null;
    return $itampaV / $varzaOhm;
}
function kainaSuNuolaida($kaina, $nuolaidaProc) {
    if ($nuolaidaProc === null || $nuolaidaProc <= 0) return $kaina;
    return $kaina * (1 - $nuolaidaProc / 100);
}
function prekeIsParduota($preke) {
    if (!isset($preke["kiekis"])) return true;
    if ($preke["kiekis"] <= 0) return true;
    return false;
}
function prekePilnai($preke) {
    $pav = isset($preke["pavadinimas"]) ? $preke["pavadinimas"] : "Be pavadinimo";
    $kaina = isset($preke["kaina"]) ? $preke["kaina"] : null;
    $img = isset($preke["paveiksliukas"]) ? $preke["paveiksliukas"] : "";
    $kiekis = isset($preke["kiekis"]) ? $preke["kiekis"] : null;
    $apras = isset($preke["aprasymas"]) ? $preke["aprasymas"] : "";
    $nuolaida = isset($preke["nuolaida"]) ? $preke["nuolaida"] : null;

    $out = "<div style='border:1px solid #ddd;padding:10px;margin:10px 0'>";
    $out .= "<div style='font-weight:bold'>" . htmlspecialchars($pav) . "</div>";

    if ($img != "") {
        $out .= "<img src='" . htmlspecialchars($img) . "' style='max-width:220px;display:block;margin:6px 0'>";
    }

    if ($kaina !== null) {
        if ($nuolaida !== null && $nuolaida > 0) {
            $new = kainaSuNuolaida($kaina, $nuolaida);
            $out .= "<div>Kaina: <span style='text-decoration:line-through'>" . number_format($kaina, 2, ".", "") . " €</span> ";
            $out .= "<b>" . number_format($new, 2, ".", "") . " €</b></div>";
        } else {
            $out .= "<div>Kaina: <b>" . number_format($kaina, 2, ".", "") . " €</b></div>";
        }
    }

    if (prekeIsParduota($preke)) {
        $out .= "<div style='color:#b00020'><b>Prekė išparduota</b></div>";
    } else {
        $out .= "<div>Kiekis sandėlyje: " . (int)$kiekis . "</div>";
    }

    if ($apras != "") {
        $out .= "<div>Aprašymas: " . htmlspecialchars($apras) . "</div>";
    }

    $out .= "</div>";
    return $out;
}
function prekeKatalogui($preke) {
    $pav = isset($preke["pavadinimas"]) ? $preke["pavadinimas"] : "Be pavadinimo";
    $kaina = isset($preke["kaina"]) ? $preke["kaina"] : null;
    $img = isset($preke["paveiksliukas"]) ? $preke["paveiksliukas"] : "";
    $nuolaida = isset($preke["nuolaida"]) ? $preke["nuolaida"] : null;

    $out = "<div style='border:1px solid #eee;padding:10px;margin:10px 0;display:flex;gap:10px;align-items:center'>";

    if ($img != "") {
        $out .= "<img src='" . htmlspecialchars($img) . "' style='width:90px;height:90px;object-fit:cover'>";
    } else {
        $out .= "<div style='width:90px;height:90px;background:#f3f3f3'></div>";
    }

    $out .= "<div>";
    $out .= "<div style='font-weight:bold'>" . htmlspecialchars($pav) . "</div>";

    if (prekeIsParduota($preke)) {
        $out .= "<div style='color:#b00020'>Išparduota</div>";
    } else {
        if ($kaina !== null) {
            if ($nuolaida !== null && $nuolaida > 0) {
                $new = kainaSuNuolaida($kaina, $nuolaida);
                $out .= "<div><span style='text-decoration:line-through'>" . number_format($kaina, 2, ".", "") . " €</span> ";
                $out .= "<b>" . number_format($new, 2, ".", "") . " €</b></div>";
            } else {
                $out .= "<div><b>" . number_format($kaina, 2, ".", "") . " €</b></div>";
            }
        }
    }

    $out .= "</div></div>";
    return $out;
}
function prekiuSarasas($prekes) {
    $out = "";
    for ($i = 0; $i < count($prekes); $i++) {
        $out .= prekeKatalogui($prekes[$i]);
    }
    return $out;
}
