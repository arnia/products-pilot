<?php

class ProductsController extends Controller{

    private function gotologin(){
        $this->_template = new Template($this->_controller,'gotologin');
        $this->set('title','GoToLogin');
        $this->set('controller',$this->_controller);
        $this->_template->render();
    }

    public function viewall(){
        if(!User::isAuth()){
            $this->gotologin();
        }
        else{
            $this->set('title','Products');
            $this->set('products',$this->Product->getAllProducts());
            $this->set('controller',$this->_controller);

            $this->_template->render();
        }
    }
    public function add_edit($id=NULL){
        if(!User::isAuth()){
            $this->gotologin();
        }
        else {
            $this->set('title','Add a new product or Delete a product');
            $this->set('product',$this->Product->select($id));
            $this->set('controller',$this->_controller);
            if ($id) $this->set('new',false);
            else $this->set('new',true);

            $this->_template->render();
        }
    }
    public function delete(){
        $id = $_POST['id'];
        $file = $_POST['file'];
        $this->set('title','');
        $this->Product->delete($id,$file);
        //header("Location:". ROOT . '/' . $this->_controller .'/viewall');
        //exit();
        $this->_template->render();
    }
    public function save(){
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

        $path = Router::buildPath(array($this->_controller,'viewall'));
        header("Location:" . $path);
        exit();
    }
}