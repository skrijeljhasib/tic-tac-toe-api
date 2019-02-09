<?php

/**
 * @OA\Info(
 *     title="Tic Tac Toe API",
 *     version="1.0",
 *     @OA\Contact(
 *        email="skrijelj-hasib@hotmail.com"
 *    )
 * )
 */

use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

// Get settings
$settings = require __DIR__ . '/../app/settings.php';

// Instantiate the app
$app = new App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Run app
$app->run();
