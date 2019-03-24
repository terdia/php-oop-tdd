<?php
declare(strict_types = 1);

require_once __DIR__ .'/vendor/autoload.php';

$config = \App\Helpers\Config::get('app');
var_dump($config);
