<?php

// 4 uzduotis: is parduotuves katalogo paimti prekes

function pilnaNuoroda($baseUrl, $link)
{
    $link = trim($link);

    if ($link === '') {
        return $baseUrl;
    }

    if (preg_match('/^https?:\/\//i', $link)) {
        return $link;
    }

    if (substr($link, 0, 2) === '//') {
        return 'https:' . $link;
    }

    $base = parse_url($baseUrl);
    $host = $base['scheme'] . '://' . $base['host'];

    if (substr($link, 0, 1) === '/') {
        return $host . $link;
    }

    $path = isset($base['path']) ? $base['path'] : '/';
    $dir = rtrim(str_replace('\\', '/', dirname($path)), '/');
    if ($dir === '' || $dir === '.') {
        $dir = '';
    }

    $full = $host . $dir . '/' . $link;

    while (strpos($full, '/../') !== false) {
        $full = preg_replace('#/[^/]+/\.\./#', '/', $full, 1);
    }

    return $full;
}

$outDir = __DIR__ . '/output';
if (!is_dir($outDir)) {
    mkdir($outDir, 0777, true);
}

$url = 'https://books.toscrape.com/index.html';
$html = file_get_contents($url);
if ($html === false) {
    die('nepavyko nuskaityti puslapio');
}

preg_match_all('/<article\s+class="product_pod".*?<\/article>/si', $html, $blocks);

$prekes = [];

foreach ($blocks[0] as $blokas) {
    $pavadinimas = '';
    $nuoroda = '';
    $paveiksliukas = '';
    $kaina = '';

    if (preg_match('/<h3>\s*<a[^>]*title=["\']([^"\']+)["\'][^>]*>/si', $blokas, $m)) {
        $pavadinimas = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    if (preg_match('/<h3>\s*<a[^>]*href=["\']([^"\']+)["\'][^>]*>/si', $blokas, $m)) {
        $nuoroda = pilnaNuoroda($url, html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    if (preg_match('/<img[^>]*src=["\']([^"\']+)["\'][^>]*>/si', $blokas, $m)) {
        $paveiksliukas = pilnaNuoroda($url, html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    if (preg_match('/<p\s+class="price_color">\s*([^<]+)\s*<\/p>/si', $blokas, $m)) {
        $kaina = trim($m[1]);
    }

    $prekes[] = [
        'pavadinimas' => $pavadinimas,
        'nuoroda' => $nuoroda,
        'paveiksliukas' => $paveiksliukas,
        'kaina' => $kaina,
    ];
}

$htmlOut = "<!doctype html>\n";
$htmlOut .= "<html lang=\"lt\">\n<head>\n<meta charset=\"utf-8\">\n<title>uzduotis 4</title>\n";
$htmlOut .= "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f5f5f5}table{width:100%;border-collapse:collapse;background:#fff}th,td{border:1px solid #ccc;padding:8px;vertical-align:top;text-align:left}img{max-width:100px;height:auto}a{word-break:break-all}</style>\n";
$htmlOut .= "</head>\n<body>\n";
$htmlOut .= "<h1>prekiu sarasas</h1>\n";
$htmlOut .= "<table>\n<tr><th>pavadinimas</th><th>nuoroda</th><th>paveiksliukas</th><th>kaina</th></tr>\n";

foreach ($prekes as $p) {
    $pav = htmlspecialchars($p['pavadinimas'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $nur = htmlspecialchars($p['nuoroda'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $img = htmlspecialchars($p['paveiksliukas'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $kai = htmlspecialchars($p['kaina'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $htmlOut .= "<tr>\n";
    $htmlOut .= "<td>$pav</td>\n";
    $htmlOut .= "<td><a href=\"$nur\" target=\"_blank\">$nur</a></td>\n";
    $htmlOut .= "<td><img src=\"$img\" alt=\"$pav\"></td>\n";
    $htmlOut .= "<td>$kai</td>\n";
    $htmlOut .= "</tr>\n";
}

$htmlOut .= "</table>\n</body>\n</html>\n";

$file = $outDir . '/uzduotis4_prekes.html';
file_put_contents($file, $htmlOut);

echo "padaryta: $file\n";
echo 'rasta prekiu: ' . count($prekes) . "\n";
