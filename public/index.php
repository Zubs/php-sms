<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Environment;

$environment = new Environment('');
$environment->load();

$secret_something = getenv('XXX_KEY');

var_dump($secret_something);
