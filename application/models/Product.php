<?php

class Product extends Model {

    private $id;
    private $name;
    private $type;
    private $price;
    private $file;
    private $image;
    private $description;

    public function __construct($params=NULL){

        parent::__construct();

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

    public function getTypeId($type){
        $query = "select id from types where name='$type'";
        return $this->query($query,1)->id;
    }

    public function add_new(){
        $fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);
        $allowedExt = array('txt', 'pdf', 'doc', 'docx');
        if (in_array($fileExtension, $allowedExt) || $this->file == NULL) {
            $completPath = UPLOAD . $this->file;
            if (!file_exists($completPath) && isset($_FILES["file"]["tmp_name"])) {
                move_uploaded_file($_FILES["file"]["tmp_name"], $completPath);
            }
        } else return null;


        $fileExtension = pathinfo($this->image, PATHINFO_EXTENSION);
        $allowedExt = array('jpg','jpeg','png');
        if (in_array($fileExtension, $allowedExt) || $this->image == NULL) {
            $completPath = IMG . $this->image;
            if (!file_exists($completPath) && isset($_FILES["image"]["tmp_name"])) {
                move_uploaded_file($_FILES["image"]["tmp_name"], $completPath);
            }
        } else return null;

        $type_id = $this->getTypeId($this->type);
        $query = "insert into products(name,type_id,price,file,image,description) values ('$this->name',$type_id,$this->price,'$this->file','$this->image','$this->description');";
        $result = $this->query($query);

        return $result;
    }

    public function update(){

        if($this->file == 'default' && $this->image == 'default'){
            $type_id = $this->getTypeId($this->type);
            $query = "update products set name='$this->name', type_id=$type_id, price=$this->price ,description='$this->description'
                      where id=$this->id";
            return $this->query($query);
        }
        elseif($this->file == 'default') {
            if($this->image){
                $fileExtension = pathinfo($this->image, PATHINFO_EXTENSION);
                $allowedExt = array('jpg', 'png', 'jpeg');
                if (in_array($fileExtension, $allowedExt)) {
                    $completPath = IMG . $this->image;
                    if (!file_exists($completPath) && isset($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $completPath);
                    }
                } else return null;
            }

            $type_id = $this->getTypeId($this->type);
            $query = "update products set name='$this->name', type_id=$type_id, price=$this->price ,description='$this->description',image='$this->image'
                      where id=$this->id";
            return $this->query($query);
        }
        elseif($this->image == 'default') {
            if($this->file){
                $fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);
                $allowedExt = array('txt', 'pdf', 'doc', 'docx');
                if (in_array($fileExtension, $allowedExt)) {
                    $completPath = UPLOAD . $this->file;
                    if (!file_exists($completPath) && isset($_FILES["file"]["tmp_name"])) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $completPath);
                    }
                } else return null;
            }

            $type_id = $this->getTypeId($this->type);
            $query = "update products set name='$this->name', type_id=$type_id, price=$this->price ,description='$this->description',file='$this->file'
                      where id=$this->id";
            return $this->query($query);
        }
        else{
            if($this->image){
                $fileExtension = pathinfo($this->image, PATHINFO_EXTENSION);
                $allowedExt = array('jpg', 'png', 'jpeg');
                if (in_array($fileExtension, $allowedExt)) {
                    $completPath = IMG . $this->image;
                    if (!file_exists($completPath) && isset($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $completPath);
                    }
                } else return null;
            }
            if($this->file){
                $fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);
                $allowedExt = array('txt', 'pdf', 'doc', 'docx');
                if (in_array($fileExtension, $allowedExt)) {
                    $completPath = UPLOAD . $this->file;
                    if (!file_exists($completPath) && isset($_FILES["file"]["tmp_name"])) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $completPath);
                    }
                } else return null;
            }

            $type_id = $this->getTypeId($this->type);
            $query = "update products set name='$this->name', type_id=$type_id, price=$this->price ,description='$this->description',file='$this->file',image='$this->image'
                      where id=$this->id";
            return $this->query($query);
        }
    }

    public function getAllProducts(){
        $query = "SELECT p.id,p.name name,t.name type,p.price,p.file,p.image,p.description FROM products p
                  left join types t on(t.id=p.type_id);";
        return $this->query($query);
    }

    public function delete($id,$file){
        if ($file != NULL) {
            $query = "SELECT id FROM products where file='" .$this->_mysqli->real_escape_string($file). "';";
            $this->query($query);
            if ($this->_result->num_rows <= 1) {
                $completPath = UPLOAD . $file;
                if(file_exists($completPath)) unlink($completPath);
            }
        }
        $query = "delete from products where id=" .$this->_mysqli->real_escape_string($id). ";";
        $this->query($query);
    }

    public function select($id){
        $query = "select p.id id,p.name name,t.name type,p.price price,p.file file,p.image image,p.description description from $this->_table p
                  join types t on(t.id=p.type_id) where p.id=$id;";
        return $this->query($query,1);
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

}