<?php
function gautiReiksme($vardas, $numatyta = '') {
    return isset($_POST[$vardas]) ? htmlspecialchars($_POST[$vardas]) : $numatyta;
}

function pazymetasSelect($reiksme, $pasirinkta) {
    return $reiksme == $pasirinkta ? 'selected' : '';
}

function pazymetasRadio($reiksme, $pasirinkta) {
    return $reiksme == $pasirinkta ? 'checked' : '';
}

function pazymetasCheckbox($reiksme, $pasirinkti) {
    return in_array($reiksme, $pasirinkti) ? 'checked' : '';
}

$restoranai = [
    'Senamiescio terasa',
    'Juros skonis',
    'Vakaro vila',
    'Miesto sodas'
];

$vietos = [2, 4, 6, 10];

$papildomosPaslaugos = [
    'Vaikiska kedute',
    'Staliukas prie lango',
    'Gimtadienio dekoracija',
    'Vegetariskas meniu'
];

$klaidos = [];
$sekminga = false;
$rezervacija = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vardas = trim($_POST['vardas'] ?? '');
    $telefonas = trim($_POST['telefonas'] ?? '');
    $restoranas = trim($_POST['restoranas'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $laikas = trim($_POST['laikas'] ?? '');
    $vietuSkaicius = trim($_POST['vietuSkaicius'] ?? '');
    $komentaras = trim($_POST['komentaras'] ?? '');
    $paslaugos = $_POST['paslaugos'] ?? [];

    if ($vardas === '') {
        $klaidos['vardas'] = 'Įveskite vardą.';
    }

    if ($telefonas === '') {
        $klaidos['telefonas'] = 'Įveskite telefono numerį.';
    } elseif (!preg_match('/^[0-9+\s-]{6,20}$/', $telefonas)) {
        $klaidos['telefonas'] = 'Neteisingas telefono numerio formatas.';
    }

    if ($restoranas === '') {
        $klaidos['restoranas'] = 'Pasirinkite restoraną.';
    } elseif (!in_array($restoranas, $restoranai)) {
        $klaidos['restoranas'] = 'Pasirinktas neteisingas restoranas.';
    }

    if ($data === '') {
        $klaidos['data'] = 'Pasirinkite datą.';
    }

    if ($laikas === '') {
        $klaidos['laikas'] = 'Pasirinkite laiką.';
    }

    if ($vietuSkaicius === '') {
        $klaidos['vietuSkaicius'] = 'Pasirinkite vietų skaičių.';
    } elseif (!in_array((int)$vietuSkaicius, $vietos)) {
        $klaidos['vietuSkaicius'] = 'Pasirinktas neteisingas vietų skaičius.';
    }

    foreach ($paslaugos as $paslauga) {
        if (!in_array($paslauga, $papildomosPaslaugos)) {
            $klaidos['paslaugos'] = 'Pasirinktos neteisingos papildomos paslaugos.';
            break;
        }
    }

    if (empty($klaidos)) {
        $sekminga = true;
        $rezervacija = [
            'Vardas' => htmlspecialchars($vardas),
            'Tel. numeris' => htmlspecialchars($telefonas),
            'Restoranas' => htmlspecialchars($restoranas),
            'Data' => htmlspecialchars($data),
            'Laikas' => htmlspecialchars($laikas),
            'Vietų skaičius' => htmlspecialchars($vietuSkaicius),
            'Komentaras' => $komentaras !== '' ? nl2br(htmlspecialchars($komentaras)) : 'Nenurodyta',
            'Papildomos paslaugos' => !empty($paslaugos) ? htmlspecialchars(implode(', ', $paslaugos)) : 'Nepasirinkta'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restorano staliuko rezervacija</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .blokas {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        }

        h1, h2 {
            margin-top: 0;
        }

        .eilute {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #cfcfcf;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .pasirinkimai label {
            display: inline-block;
            font-weight: normal;
            margin-right: 14px;
            margin-bottom: 8px;
        }

        .klaida {
            color: #c62828;
            font-size: 14px;
            margin-top: 5px;
        }

        .privalomas {
            color: #c62828;
        }

        button {
            background: #1f6feb;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1557b0;
        }

        .sekme {
            background: #eef8ee;
            border: 1px solid #b8d8b8;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .duomenys p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="blokas">
        <h1>Restorano staliuko rezervavimo forma</h1>

        <?php if ($sekminga): ?>
            <div class="sekme duomenys">
                <h2>Rezervacija sėkmingai išsiųsta</h2>
                <?php foreach ($rezervacija as $pavadinimas => $reiksme): ?>
                    <p><strong><?php echo $pavadinimas; ?>:</strong> <?php echo $reiksme; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="eilute">
                <label for="vardas">Vardas <span class="privalomas">*</span></label>
                <input type="text" id="vardas" name="vardas" value="<?php echo gautiReiksme('vardas'); ?>">
                <?php if (isset($klaidos['vardas'])): ?>
                    <div class="klaida"><?php echo $klaidos['vardas']; ?></div>
                <?php endif; ?>
            </div>

            <div class="eilute">
                <label for="telefonas">Tel. numeris <span class="privalomas">*</span></label>
                <input type="text" id="telefonas" name="telefonas" value="<?php echo gautiReiksme('telefonas'); ?>">
                <?php if (isset($klaidos['telefonas'])): ?>
                    <div class="klaida"><?php echo $klaidos['telefonas']; ?></div>
                <?php endif; ?>
            </div>

            <div class="eilute">
                <label for="restoranas">Restoranas <span class="privalomas">*</span></label>
                <select id="restoranas" name="restoranas">
                    <option value="">-- Pasirinkite restoraną --</option>
                    <?php foreach ($restoranai as $variantas): ?>
                        <option value="<?php echo htmlspecialchars($variantas); ?>" <?php echo pazymetasSelect($variantas, $_POST['restoranas'] ?? ''); ?>>
                            <?php echo htmlspecialchars($variantas); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($klaidos['restoranas'])): ?>
                    <div class="klaida"><?php echo $klaidos['restoranas']; ?></div>
                <?php endif; ?>
            </div>

            <div class="eilute">
                <label for="data">Data <span class="privalomas">*</span></label>
                <input type="date" id="data" name="data" value="<?php echo gautiReiksme('data'); ?>">
                <?php if (isset($klaidos['data'])): ?>
                    <div class="klaida"><?php echo $klaidos['data']; ?></div>
                <?php endif; ?>
            </div>

            <div class="eilute">
                <label for="laikas">Laikas <span class="privalomas">*</span></label>
                <input type="time" id="laikas" name="laikas" value="<?php echo gautiReiksme('laikas'); ?>">
                <?php if (isset($klaidos['laikas'])): ?>
                    <div class="klaida"><?php echo $klaidos['laikas']; ?></div>
                <?php endif; ?>
            </div>

            <div class="eilute pasirinkimai">
                <label>Vietų skaičius <span class="privalomas">*</span></label>
                <?php foreach ($vietos as $vieta): ?>
                    <label>
                        <input type="radio" name="vietuSkaicius" value="<?php echo $vieta; ?>" <?php echo pazymetasRadio($vieta, $_POST['vietuSkaicius'] ?? ''); ?>>
                        <?php echo $vieta; ?>
                    </label>
                <?php endforeach; ?>
                <?php if (isset($klaidos['vietuSkaicius'])): ?>
                    <div class="klaida"><?php echo $klaidos['vietuSkaicius']; ?></div>
                <?php endif; ?>
            </div>

            <div class="eilute">
                <label for="komentaras">Komentaras</label>
                <textarea id="komentaras" name="komentaras"><?php echo gautiReiksme('komentaras'); ?></textarea>
            </div>

            <div class="eilute pasirinkimai">
                <label>Papildomos paslaugos</label>
                <?php $pasirinktosPaslaugos = $_POST['paslaugos'] ?? []; ?>
                <?php foreach ($papildomosPaslaugos as $paslauga): ?>
                    <label>
                        <input type="checkbox" name="paslaugos[]" value="<?php echo htmlspecialchars($paslauga); ?>" <?php echo pazymetasCheckbox($paslauga, $pasirinktosPaslaugos); ?>>
                        <?php echo htmlspecialchars($paslauga); ?>
                    </label>
                <?php endforeach; ?>
                <?php if (isset($klaidos['paslaugos'])): ?>
                    <div class="klaida"><?php echo $klaidos['paslaugos']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Rezervuoti</button>
        </form>
    </div>
</body>
</html>
