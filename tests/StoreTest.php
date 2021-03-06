<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__ . '/../src/Store.php';
    require_once __DIR__ . '/../src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $usercourse_name = 'root';
    $password = 'root';
    $DB = new PDO($server, $usercourse_name, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_getInfo()
        {
            // Arrange
            $store_name = "Foot Locker";
            $id = 3;
            $store_phone = "503-111-2222";

            $test_store = new Store($store_name, $store_phone, $id);
            // Act
            $result1 = $test_store->getStoreName();
            $result2 = $test_store->getStorePhone();
            $result3 = $test_store->getId();
            // Assert
            $this->assertEquals($store_name, $result1);
            $this->assertEquals($store_phone, $result2);
            $this->assertEquals($id, is_numeric($result3));
        }

        function test_save()
        {
            // Arrange
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);

            // Act
            $test_store->save();
            $result = Store::getAll();

            // Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $store_name2 = "Nordstrom";
            $store_phone2 = "123-4455";
            $test_store2 = new Store($store_name2, $store_phone2, $id);
            $test_store2->save();

            // Act
            $result = Store::getAll();
            // Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_update()
        {
            // Arrange
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $new_store_name = "Nordstrom";
            $new_store_phone = "503-222-3333";

            // Act
            $test_store->update($new_store_name, $new_store_phone);
            $result = $test_store->getStoreName();
            $result2 = $test_store->getStorePhone();

            // Assert
            $this->assertEquals($new_store_name, $result);
            $this->assertEquals($new_store_phone, $result2);
        }

        function test_deleteOneStore()
        {
            // Arrange
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $store_name2 = "Nordstrom";
            $store_phone2 = "123-4455";
            $test_store2 = new Store($store_name2, $store_phone2, $id);
            $test_store2->save();

            // Act
            $test_store->deleteOneStore();
            $result = Store::getAll();

            // Assert
            $this->assertEquals([$test_store2], $result);
        }

        function test_findById()
        {
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $store_name2 = "Nordstrom";
            $store_phone2 = "123-4455";
            $test_store2 = new Store($store_name2, $store_phone2, $id);
            $test_store2->save();

            $result = Store::findById($test_store->getId());

            $this->assertEquals($test_store, $result);
        }

        function test_findByName()
        {
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $store_name2 = "Nordstrom";
            $store_phone2 = "123-4455";
            $test_store2 = new Store($store_name2, $store_phone2, $id);
            $test_store2->save();

            $result = Store::findByName($test_store->getStoreName());

            $this->assertEquals($test_store, $result);
        }

        function test_addBrand()
        {
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            $test_store->addBrand($test_brand);

            $this->assertEquals($test_store->getBrands(), [$test_brand]);
        }

        function test_getBrands()
        {
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";
            $test_store = new Store($store_name, $store_phone, $id);
            $test_store->save();

            $name = "Nike";
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
        }

    }
 ?>
