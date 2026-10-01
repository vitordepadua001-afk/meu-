<?php

function stressTest(int $limit): void {
    for($i = 0; $i < $limit; $i++) {

    }
}
echo "Start tests:\n";
stressTest(500.000);
echo "Tests successfully completed.\n";