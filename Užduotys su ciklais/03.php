<?php
for ($i = 1; $i <= 100; $i++) {
    if ($i % 5 === 0) {
        echo $i;
        if ($i < 100) echo "\n";
    }
}
