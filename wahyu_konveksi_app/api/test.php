<?php
echo "PHP VERSION: " . PHP_VERSION . "\n";
echo "DIR: " . __DIR__ . "\n";
echo "VENDOR EXISTS: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'YES' : 'NO') . "\n";
echo "BOOTSTRAP EXISTS: " . (file_exists(__DIR__ . '/../bootstrap/app.php') ? 'YES' : 'NO') . "\n";
echo "PUBLIC EXISTS: " . (file_exists(__DIR__ . '/../public/index.php') ? 'YES' : 'NO') . "\n";
try {
    $pdo = new PDO("mysql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 3]);
    echo "DB: CONNECTED\n";
} catch (Exception $e) {
    echo "DB ERROR: " . $e->getMessage() . "\n";
}
