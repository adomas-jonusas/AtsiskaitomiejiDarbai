<?php
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Darbas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $darboTekstas = $_POST['darbas'] ?? '';
    $laikas = $_POST['laikas'] ?? '';

    if (is_string($darboTekstas) && is_string($laikas)) {
        $darboTekstas = trim($darboTekstas);

        if ($darboTekstas !== '' && mb_strlen($darboTekstas, 'UTF-8') <= 255) {
            if ($laikas === '') {
                $laikas = null;
            } else {
                $data = DateTime::createFromFormat('!Y-m-d\TH:i', $laikas);

                if (!$data || $data->format('Y-m-d\TH:i') !== $laikas) {
                    header('Location: index.php');
                    exit;
                }

                $laikas = $data->format('Y-m-d H:i:s');
            }

            $database = new Database();
            $darbas = new Darbas($database->getConnection());
            $darbas->prideti($darboTekstas, $laikas);
        }
    }
}

header('Location: index.php');
exit;
