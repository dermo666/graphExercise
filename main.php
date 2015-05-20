<?php
require_once __DIR__.'/classes/PathFinder.php';

$filename = isset($argv[1]) ? $argv[1] : '';

if (empty($filename)) {
    echo "Filename missing - please use following format: php main.php /some/filename.csv \n";
} else if (!file_exists($filename)) {
    echo "File not not: $filename \n";
} else {
    $fileRows = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines    = [];
    
    foreach ($fileRows as $row) {
        $lines[] = explode(',', $row);
    }
    
    $pathFinder = new PathFinder($lines);

    while (true) {
        $entry = trim(fgets(STDIN));

        if ($entry == 'QUIT')
            break;
        
        $entries = explode(' ', $entry);
        $path    = $pathFinder->findPath($entries[0], $entries[1], $entries[2]);
        
        echo "$path\n";
    }
    
}
