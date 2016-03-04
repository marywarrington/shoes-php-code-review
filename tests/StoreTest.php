<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    require_once __DIR__ . '/../src/Store.php';
    // require_once __DIR__ . '/../src/Brand.php';

    $server = 'mysql:host=localhost;dbcourse_name=shoes_test';
    $usercourse_name = 'root';
    $password = 'root';
    $DB = new PDO($server, $usercourse_name, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            // Brand::deleteAll();
        }

        function test_getInfo()
        {
            // Arrange
            $store_name = "Foot Locker";
            $id = null;
            $store_phone = "503-111-2222";

            $test_store = new Store($store_name, $store_phone, $id);
            // Act
            $result1 = $test_store->getStoreName();
            $result2 = $test_store->getStorePhone();
            $result3 = $test_store->getId();
            // Assert
            $this->assertEquals($store_name, $result1);
            $this->assertEquals($store_phone, $result2);
            $this->assertEquals($id, $result3);
        }

    }
 ?>
