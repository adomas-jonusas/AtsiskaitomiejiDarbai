<?php
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Darbas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {
        $database = new Database();
        $darbas = new Darbas($database->getConnection());
        $darbas->pazymetiAtlikta($id);
    }
}

header('Location: index.php');
exit;
