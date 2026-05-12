<?php

// 1 uzduotis: daugybos lentele i txt faila

$outDir = __DIR__ . '/output';
if (!is_dir($outDir)) {
    mkdir($outDir, 0777, true);
}

$file = $outDir . '/uzduotis1_daugybos_lentele.txt';
$fp = fopen($file, 'w');

if (!$fp) {
    die('nepavyko atidaryti failo');
}

for ($i = 1; $i <= 9; $i++) {
    for ($j = 1; $j <= 9; $j++) {
        $line = $i . '*' . $j . '=' . ($i * $j) . "\n";
        fwrite($fp, $line);
    }
    fwrite($fp, "\n");
}

fclose($fp);
echo "padaryta: $file\n";
