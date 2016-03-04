<?php
    require_once __DIR__."/../vendor/autoload.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });


    return $app;
?>
