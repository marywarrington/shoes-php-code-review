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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (store_name, store_phone) VALUES ('{$this->getStoreName()}', '{$this->getStorePhone()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }


    }
?>
