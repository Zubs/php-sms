<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Environment;
use App\SMSNotification;

$environment = new Environment('');
$environment->load();

$notification = new SMSNotification();
$notification->setBody("I love myself. I love PHP");
$notification->setTo('+15558675310');
$test = $notification->send();

echo $test;
