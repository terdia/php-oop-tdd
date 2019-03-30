<?php
declare(strict_types = 1);

require_once __DIR__ .'/vendor/autoload.php';

require_once __DIR__ . '/Src/Exception/exception.php';

$logger = new \App\Logger\Logger();
$logger->log(
    \App\Logger\LogLevel::EMERGENCY, 'There is an emergency', ['exception' => 'excetion occured']
);
$logger->info('User account created successfully', ['id' => 5]);


