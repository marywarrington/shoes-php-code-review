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

    $app->post("{id}/add_brand", function($id) use ($app) {
        $store = Store::findById($id);
        $brand = Brand::findById($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array(
            'store' => $store,
            'store_brands' => $store->getBrands(),
            'brands' => Brand::getAll()
        ));
    });

    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array(
            'brands' => Brand::getAll()
        ));
    });

    $app->post("/brands", function() use ($app) {
        $new_brand = new Brand($_POST['brand_name']);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array(
            'brands' => Brand::getAll()
        ));
    });

    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::findById($id);
        return $app['twig']->render('brand.html.twig', array(
            'brand' => $brand,
            'brand_stores' => $brand->getStores(),
            'stores' => Store::getAll()
        ));
    });

    $app->post("/{id}/add_store", function($id) use ($app) {
        $brand = Brand::findById($id);
        $store = Store::findById($_POST['id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array(
            'brand' => $brand,
            'brand_stores' => $brand->getStores(),
            'stores' => Store::getAll()
        ));
    });

    $app->delete("/{id}/delete_brand", function($id) use ($app) {
        $brand = Brand::findById($id);
        $brand->deleteOneBrand();
        return $app['twig']->render('brands.html.twig', array(
            'brands' => Brand::getAll()
        ));
    });

    return $app;
?>
