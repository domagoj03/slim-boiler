<?php 

session_start();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, 
        ],
    ]);

$container = $app->getContainer();

$container['db'] = function () {
    return new PDO('mysql:host=localhost;dbname=slim', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
};

$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};


$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new App\Views\CsrfExtension($container['csrf']));

    return $view;
};

$app->add($container->get('csrf'));

require __DIR__ . '/../routes/web.php';