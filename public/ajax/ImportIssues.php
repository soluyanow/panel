<?php

define('LARAVEL_START', microtime(true));

require ($_SERVER['DOCUMENT_ROOT'] . '/../app/Classes/EmailReader.php');

require ($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php');

$app = require_once ($_SERVER['DOCUMENT_ROOT'] . '/../bootstrap/app.php');

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

$ob = new App\Classes\EmailReader();

$ob->execute();
