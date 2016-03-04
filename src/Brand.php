<?php
    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getBrandName()
        {
            return $this->name;
        }

        function setBrandName($new_name)
        {
            $this->name = $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands SET brand_name = '{$new_name}';");
            $this->setBrandName($new_name);
        }

        function deleteOneBrand()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        //add delete from join table here
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN stores_brands ON (brands.id = stores_brands.brand_id)
                JOIN stores ON (stores_brands.store_id = stores.id)
                WHERE brands.id = {$this->getId()};");

            $stores = [];
            foreach($returned_stores as $store) {

                $store_name = $store['store_name'];
                $store_phone = $store['store_phone'];
                $id = $store['id'];
                $new_store = new Store($store_name, $store_phone, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function findById($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                if ($brand->getId() == $search_id)
                {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        static function findByName($search_name)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                if ($brand->getBrandName() == $search_name)
                {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();

            foreach($returned_brands as $brand) {
                $name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

    }
?>
