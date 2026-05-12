<?php

// 2 uzduotis: isrinkti visas a nuorodas i txt faila

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

preg_match_all('/<a[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/si', $html, $matches, PREG_SET_ORDER);

$lines = [];
foreach ($matches as $m) {
    $href = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $name = strip_tags($m[2]);
    $name = html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $name = preg_replace('/\s+/u', ' ', trim($name));

    if ($name === '') {
        $name = '(be pavadinimo)';
    }

    $lines[] = $name . '; ' . pilnaNuoroda($url, $href) . ';';
}

$file = $outDir . '/uzduotis2_nuorodos.txt';
file_put_contents($file, implode("\n", $lines) . "\n");

echo "padaryta: $file\n";
echo 'rasta nuorodu: ' . count($lines) . "\n";
