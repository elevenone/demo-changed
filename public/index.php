<?php

declare(strict_types=1);

ini_set('error_reporting', '32767');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

use Framework\Http\Application;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter as Runner;
use Laminas\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';
$config = $container->get('config');

/** @var Application $app */
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$request = (new ServerRequestFactory)->fromGlobals();
$response = $app->handle($request);

$response =
    $response->withHeader('X-Developer', 'Arslanoov');

$runner = new Runner();
$runner->emit($response);