<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__ . '/../src/Store.php';
    // require_once __DIR__ . '/../src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $usercourse_name = 'root';
    $password = 'root';
    $DB = new PDO($server, $usercourse_name, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
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
            $store_phone2 = "Jimmy Choo";
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

    }
 ?>
