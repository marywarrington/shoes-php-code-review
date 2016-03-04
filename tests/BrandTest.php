<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__ . '/../src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
        }

        function test_getInfo()
        {
            // Arrange
            $name = "Nike";
            $id = null;

            $test_brand = new Brand($name, $id);
            // Act
            $result1 = $test_brand->getBrandName();
            $result2 = $test_brand->getId();
            // Assert
            $this->assertEquals($name, $result1);
            $this->assertEquals($id, $result2);
        }

        function test_save()
        {
            // Arrange
            $name = "Nike";
            $id = null;
            $test_brand = new Brand($name, $id);

            // Act
            $test_brand->save();
            $result = Brand::getAll();
            // Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $name = "Nike";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();

            // Act
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_update()
        {
            // Arrange
            $name = "Nike";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $new_name = "Adidas";

            // Act
            $test_brand->update($new_name);
            $result = $test_brand->getBrandName();

            // Assert
            $this->assertEquals($new_name, $result);
        }

        function test_findById()
        {
            // Arrange
            $name = "Nike";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();

            // Act
            $result = Brand::findById($test_brand->getId());

            // Assert
            $this->assertEquals($test_brand, $result);
        }

        function test_findByName()
        {
            // Arrange
            $name = "Nike";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();

            // Act
            $result = Brand::findByName($test_brand->getBrandName());

            // Assert
            $this->assertEquals($test_brand, $result);
        }


    }


 ?>
