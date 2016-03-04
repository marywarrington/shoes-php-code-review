<?php
    class Store
    {
        private $store_name;
        private $store_phone;
        private $id;

        function __construct($store_name, $store_phone, $id = null)
        {
            $this->store_name = $store_name;
            $this->store_phone = $store_phone;
            $this->id = $id;
        }

        function getStoreName()
        {
            return $this->store_name;
        }

        function setStoreName($new_store_name)
        {
            $this->store_name = $new_store_name;
        }

        function getStorePhone()
        {
            return $this->store_phone;
        }

        function setStorePhone($new_store_phone)
        {
            $this->store_phone = $new_store_phone;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (store_name, store_phone) VALUES ('{$this->getStoreName()}', '{$this->getStorePhone()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_store_name, $new_store_phone)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores SET store_name = '{$new_store_name}', store_phone = '{$new_store_phone}';");
            $this->setStoreName($new_store_name);
            $this->setStorePhone($new_store_phone);
        }

        function deleteOneStore()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
//add delete from store_brand
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();

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
            $found_store = null;
            $stores = Store::getAll();

            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        static function findByName($search_name)
        {
            $found_store = null;
            $stores = Store::getAll();

            foreach($stores as $store) {
                $store_name = $store->getStoreName();
                if ($store_name == $search_name) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }


    }
?>
