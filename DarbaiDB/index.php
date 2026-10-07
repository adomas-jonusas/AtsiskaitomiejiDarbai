<?php
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Darbas.php';

$database = new Database();
$darbas = new Darbas($database->getConnection());
$darbai = $darbas->gautiVisus();
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darbų sąrašas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="kortele">
        <h1>Darbų sąrašas</h1>

        <form action="prideti.php" method="post" class="pridejimo-forma">
            <label for="darbas">Darbas:</label>
            <input type="text" id="darbas" name="darbas" maxlength="255" required>

            <label for="laikas">Laikas (neprivalomas):</label>
            <input type="datetime-local" id="laikas" name="laikas">

            <button type="submit">Pridėti</button>
        </form>

        <?php if (!$darbai): ?>
            <p>Darbų nėra.</p>
        <?php else: ?>
            <ul class="darbu-sarasas">
                <?php foreach ($darbai as $irasas): ?>
                    <?php
                    $klase = '';
                    if ($irasas['atliktas']) {
                        $klase = 'atliktas';
                    } elseif ($irasas['paveluotas']) {
                        $klase = 'paveluotas';
                    }
                    ?>
                    <li class="darbas <?= $klase ?>">
                        <div>
                            <strong class="darbo-tekstas"><?= htmlspecialchars($irasas['darbas'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <p class="terminas">
                                <?= $irasas['laikas'] === null ? 'Be termino' : htmlspecialchars(date('Y-m-d H:i', strtotime($irasas['laikas'])), ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <?php if ($irasas['atliktas']): ?>
                                <span>Atliktas</span>
                            <?php elseif ($irasas['paveluotas']): ?>
                                <span>Pavėluotas</span>
                            <?php endif; ?>
                        </div>

                        <?php if (!$irasas['atliktas']): ?>
                            <form action="atlikti.php" method="post">
                                <input type="hidden" name="id" value="<?= (int) $irasas['id'] ?>">
                                <button type="submit">Atlikta</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>
</html>
