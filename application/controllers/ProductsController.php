<?php

class ProductsController extends Controller{
    public function viewall(){
        $this->set('title','Products');
        $this->set('products',$this->Product->getAllProducts());
    }
    public function add_edit($id=NULL){
        $this->set('title','Add a new product or Delete a product');
        $this->set('product',$this->Product->select($id));
        $this->set('controller',$this->_controller);
        if ($id) $this->set('new',false);
            else $this->set('new',true);
    }
    public function delete($id,$file){
        $this->set('title','Delete a product');
        $this->Product->delete($id,$file);
    }
    public function save(){
        $this->set('title','Save a product');
        if(isset($_POST['type'])&&isset($_POST['name'])&&isset($_POST['price'])) {
            $this->Product->setId($_POST['id']);
            $this->Product->setName($_POST['name']);
            $this->Product->setPrice($_POST['price']);
            $this->Product->setType($_POST['type']);
            if(isset($_FILES["file"]["name"]))  $this->Product->setFile(basename($_FILES["file"]["name"]));
            else $this->Product->setFile('default');

            if ($this->Product->getId()) {
                if($this->Product->update()) $this->set('succes',true);
                else $this->set('succes',false);
            }
                else {
                    if($this->Product->add_new()) $this->set('succes',true);
                    else $this->set('succes',false);
                }
        }
    }

}