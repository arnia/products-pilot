<?php

    class Product {

        private $id;
        private $name;
        private $type;
        private $price;
        private $file;

        public function __construct($params){
            if(isset($params['id'])){
                $this->id = $params['id'];
            }
            if(isset($params['name'])){
                $this->name = $params['name'];
            }
            if(isset($params['type'])){
                $this->type = $params['type'];
            }
            if(isset($params['price'])){
                $this->price = $params['price'];
            }
            if(isset($params['file'])){
                $this->file = $params['file'];
            }
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @param mixed $type
         */
        public function setType($type)
        {
            $this->type = $type;
        }

        /**
         * @return mixed
         */
        public function getPrice()
        {
            return $this->price;
        }

        /**
         * @param mixed $price
         */
        public function setPrice($price)
        {
            $this->price = $price;
        }
        /**
         * @return mixed
         */
        public function getFile()
        {
            return $this->file;
        }

        /**
         * @param mixed $file
         */
        public function setFile($file)
        {
            $this->file = $file;
        }
    }