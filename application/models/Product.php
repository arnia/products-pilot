<?php

class Product extends Model {

    private $id;
    private $name;
    private $type;
    private $price;
    private $file;

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

        $type_id = $this->getTypeId($this->type);
        $query = "insert into products(name,type_id,price,file) values ('$this->name',$type_id,$this->price,'$this->file');";
        return $this->query($query);
    }

    public function update(){

        if($this->file){
            if($this->file=='default'){
                $type_id = $this->getTypeId($this->type);
                $query = "update products set name='$this->name', type_id=$type_id, price=$this->price
                      where id=$this->id";
                return $this->query($query);
            }
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
            $query = "update products set name='$this->name', type_id=$type_id, price=$this->price, file='$this->file'
                      where id=$this->id";
            return $this->query($query);
    }

    public function getAllProducts(){
        $query = "SELECT p.id,p.name name,t.name type,p.price,p.file FROM products p
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
        $query = "select p.id id,p.name name,t.name type,p.price price,p.file file from $this->_table p
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
}