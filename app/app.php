<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

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

    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array(
        'stores' => Store::getAll()
        ));
    });

    $app->post("/stores", function() use ($app) {
        $new_store = new Store($_POST['store_name'], $_POST['store_phone']);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array(
            'stores' => Store::getAll()
        ));
    });

    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::findById($id);
        return $app['twig']->render('store.html.twig', array(
            'store' => $store,
            'store_brands' => $store->getBrands(),
            'brands' => Brand::getAll()
        ));
    });

    return $app;
?>
