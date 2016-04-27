<?php
// load classes
// ---------------------------------------
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$templatesPath = __DIR__ . '/../templates';

// register Twig with Silex
// -------------------------
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $templatesPath
));
