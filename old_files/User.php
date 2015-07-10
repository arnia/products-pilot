<?php

    class User{
        private $id;
        private $email;
        private $password;
        private $hash;
        private $verified;

        public function __construct($email, $password, $hash, $verified)
        {
            $this->email = $email;
            $this->password = $password;
            $this->hash = $hash;
            $this->verified = $verified;
        }
        /**
         * @return mixed
         */
        public function getHash()
        {
            return $this->hash;
        }

        /**
         * @param mixed $hash
         */
        public function setHash($hash)
        {
            $this->hash = $hash;
        }

        /**
         * @return mixed
         */
        public function getVerified()
        {
            return $this->verified;
        }

        /**
         * @param mixed $verified
         */
        public function setVerified($verified)
        {
            $this->verified = $verified;
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
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }
    }