<?php
ini_set('memory_limit', '512M');
set_time_limit(0);

function clearList(array &$array) {
    for($i = 0; $i < 5; $i++) {
        array_pop($array);
    }
}

function stressTest(int $limit) {
    $list = array();
    $bytesNeeded = 1024;
    for($i = 0; $i < $limit; $i++) {
        $randomString = bin2hex(random_bytes($bytesNeeded));
        $randomString = hash('sha256', $randomString);
        array_push($list, $randomString);
        if($i > 0 && $i % 1000 === 0) {
            clearList($list);
        }
    }
    return $list;
}

echo "Start tests:\n";
$results = stressTest(100_000);
echo "Tests successfully completed: " . count($results) . "\n";