<?php
echo "<table border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>";

for ($r = 0; $r < 8; $r++) {
    echo "<tr>";
    for ($c = 0; $c < 8; $c++) {
        $black = (($r + $c) % 2 === 1);
        $color = $black ? "#000" : "#fff";
        echo "<td style='width:40px;height:40px;background:" . $color . ";'></td>";
    }
    echo "</tr>";
}

echo "</table>";
