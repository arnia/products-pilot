<?php

class Application_Model_Product {

    private $id;
    private $name;
    private $category_id;
    private $price;
    private $file;
    private $image;
    private $description;

    public function __construct($params=NULL){

        if(isset($params['id']) && !empty($params['id'])){
            $this->id = $params['id'];
        }
        if(isset($params['name']) && !empty($params['name'])){
            $this->name = $params['name'];
        }
        if(isset($params['category_id']) && !empty($params['category_id'])){
            $this->category_id = $params['category_id'];
        }
        if(isset($params['price']) && !empty($params['price'])){
            $this->price = $params['price'];
        }
        if(isset($params['file']) && !empty($params['file'])){
            $this->file = $params['file'];
        }
        if(isset($params['image']) && !empty($params['image'])){
            $this->image = $params['image'];
        }
        if(isset($params['description']) && !empty($params['description'])){
            $this->description = $params['description'];
        }
    }


    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid product property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid product property');
        }
        return $this->$method();
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
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
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

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCategoryName(){
        $categoryMapper = new Application_Model_CategoryMapper();
        $category = $categoryMapper->find($this->category_id);

        return $category->name;
    }

}