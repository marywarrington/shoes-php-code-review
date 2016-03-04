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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }
    }
?>
