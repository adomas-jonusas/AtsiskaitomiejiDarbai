<?php

// 3 uzduotis: isrinkti img ir sugeneruoti html

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

preg_match_all('/<img[^>]*src=["\']([^"\']+)["\'][^>]*>/si', $html, $matches, PREG_SET_ORDER);

$imgs = [];
$seen = [];

foreach ($matches as $m) {
    $tag = $m[0];
    $src = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $src = pilnaNuoroda($url, $src);

    if (isset($seen[$src])) {
        continue;
    }
    $seen[$src] = true;

    $alt = 'paveiksliukas';
    if (preg_match('/alt=["\']([^"\']*)["\']/i', $tag, $altM)) {
        $alt = trim(html_entity_decode($altM[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($alt === '') {
            $alt = 'paveiksliukas';
        }
    }

    $imgs[] = ['src' => $src, 'alt' => $alt];
}

$htmlOut = "<!doctype html>\n";
$htmlOut .= "<html lang=\"lt\">\n<head>\n<meta charset=\"utf-8\">\n<title>uzduotis 3</title>\n";
$htmlOut .= "<style>body{font-family:Arial,sans-serif;background:#f5f5f5;padding:20px}.blokas{display:inline-block;background:#fff;border:1px solid #ddd;margin:8px;padding:8px;vertical-align:top}img{max-width:220px;height:auto;display:block;margin-bottom:6px}</style>\n";
$htmlOut .= "</head>\n<body>\n";
$htmlOut .= "<h1>isrinkti paveiksliukai</h1>\n";

foreach ($imgs as $img) {
    $safeSrc = htmlspecialchars($img['src'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeAlt = htmlspecialchars($img['alt'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $htmlOut .= "<div class=\"blokas\">\n";
    $htmlOut .= "<img src=\"$safeSrc\" alt=\"$safeAlt\">\n";
    $htmlOut .= "<div>$safeAlt</div>\n";
    $htmlOut .= "</div>\n";
}

$htmlOut .= "</body>\n</html>\n";

$file = $outDir . '/uzduotis3_paveiksliukai.html';
file_put_contents($file, $htmlOut);

echo "padaryta: $file\n";
echo 'rasta paveiksliuku: ' . count($imgs) . "\n";
