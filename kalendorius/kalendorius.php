<?php

function menesioPavadinimas($menuo) {
    $menesiai = array(
        1 => "Sausis",
        2 => "Vasaris",
        3 => "Kovas",
        4 => "Balandis",
        5 => "Gegužė",
        6 => "Birželis",
        7 => "Liepa",
        8 => "Rugpjūtis",
        9 => "Rugsėjis",
        10 => "Spalis",
        11 => "Lapkritis",
        12 => "Gruodis"
    );

    if (isset($menesiai[$menuo])) {
        return $menesiai[$menuo];
    }

    return "";
}

function savaitesDienos() {
    $dienos = array("Pr", "A", "T", "K", "Pe", "Š", "S");
    $html = "<tr>";

    // Sudedami savaitės dienų pavadinimai į lentelės antraštę
    for ($i = 0; $i < count($dienos); $i++) {
        $html .= "<th>" . $dienos[$i] . "</th>";
    }

    $html .= "</tr>";

    return $html;
}

function pirmaDiena($metai, $menuo) {
    // N grąžina savaitės dienos numerį nuo 1 iki 7, kur 1 yra pirmadienis
    return date("N", mktime(0, 0, 0, $menuo, 1, $metai));
}

function dienuSkaicius($metai, $menuo) {
    // t grąžina, kiek konkrečiame mėnesyje yra dienų
    return date("t", mktime(0, 0, 0, $menuo, 1, $metai));
}

function siandien($metai, $menuo, $diena) {
    $siandien = date("Y-m-d");
    $tikrinamaData = $metai . "-" . str_pad($menuo, 2, "0", STR_PAD_LEFT) . "-" . str_pad($diena, 2, "0", STR_PAD_LEFT);

    if ($siandien == $tikrinamaData) {
        return true;
    }

    return false;
}

function kalendorius($metai, $menuo) {
    $pirma = pirmaDiena($metai, $menuo);
    $dienuKiekis = dienuSkaicius($metai, $menuo);

    // Apskaičiuojamas praėjęs mėnuo
    $praeitasMenuo = $menuo - 1;
    $praeitiMetai = $metai;

    if ($praeitasMenuo == 0) {
        $praeitasMenuo = 12;
        $praeitiMetai--;
    }

    // Apskaičiuojamas kitas mėnuo
    $kitasMenuo = $menuo + 1;
    $kitiMetai = $metai;

    if ($kitasMenuo == 13) {
        $kitasMenuo = 1;
        $kitiMetai++;
    }

    $praeitoMenesioDienos = dienuSkaicius($praeitiMetai, $praeitasMenuo);
    $langeliuPriekyje = $pirma - 1;

    $html = "<table class='kalendorius'>";
    $html .= "<caption>" . $metai . " " . menesioPavadinimas($menuo) . "</caption>";
    $html .= "<thead>" . savaitesDienos() . "</thead>";
    $html .= "<tbody>";

    $einamaDiena = 1;
    $kitoMenesioDiena = 1;

    // Daromos 6 savaitės eilutės, kad visada tilptų visas mėnuo
    for ($savaite = 0; $savaite < 6; $savaite++) {
        $html .= "<tr>";

        for ($stulpelis = 1; $stulpelis <= 7; $stulpelis++) {
            $pozicija = $savaite * 7 + $stulpelis;
            $klase = "";

            // Užpildomos pradžios dienos iš praėjusio mėnesio
            if ($pozicija <= $langeliuPriekyje) {
                $diena = $praeitoMenesioDienos - $langeliuPriekyje + $pozicija;
                $einamiMetai = $praeitiMetai;
                $einamasMenuo = $praeitasMenuo;
                $klase = "kitas";
            }
            // Užpildomos einamojo mėnesio dienos
            else if ($einamaDiena <= $dienuKiekis) {
                $diena = $einamaDiena;
                $einamaDiena++;
                $einamiMetai = $metai;
                $einamasMenuo = $menuo;
            }
            // Užpildomos likusios dienos iš kito mėnesio
            else {
                $diena = $kitoMenesioDiena;
                $kitoMenesioDiena++;
                $einamiMetai = $kitiMetai;
                $einamasMenuo = $kitasMenuo;
                $klase = "kitas";
            }

            // Patikrinama, ar ši diena yra šiandien
            if (siandien($einamiMetai, $einamasMenuo, $diena)) {
                if ($klase != "") {
                    $klase .= " ";
                }

                $klase .= "siandien";
            }

            if ($klase != "") {
                $html .= "<td class='" . $klase . "'>" . $diena . "</td>";
            } else {
                $html .= "<td>" . $diena . "</td>";
            }
        }

        $html .= "</tr>";
    }

    $html .= "</tbody></table>";

    return $html;
}

$metai = date("Y");
$menuo = date("n");
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendorius</title>
    <style>
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f3f3f3;
        }

        .blokas {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #cccccc;
        }

        .kalendorius {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .kalendorius caption {
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: bold;
            text-align: left;
        }

        .kalendorius th,
        .kalendorius td {
            border: 1px solid #999999;
            text-align: center;
            padding: 10px 0;
        }

        .kalendorius th {
            background: #e2e2e2;
        }

        .kalendorius .kitas {
            color: #888888;
            background: #f9f9f9;
        }

        .kalendorius .siandien {
            background: #ffd966;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="blokas">
        <?php echo kalendorius($metai, $menuo); ?>
    </div>
</body>
</html>
