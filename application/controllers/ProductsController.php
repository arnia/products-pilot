<?php

class ProductsController extends Zend_Controller_Action {
    const MIN = 0;
    const MAX = 5000;
    const VALIDATE_FORM = 'validateForm';
    const DELETE_FIELD = 'delete_field';


    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        return $this->_helper->redirector('shop');
    }

    public function shopAction(){
        $category_id = $this->getParam('category');
        $productMapper = new Application_Model_ProductMapper();
        $categoriesMapper = new Application_Model_CategoryMapper();
        $this->view->headScript()->appendFile(JS_DIR . '/' . self::VALIDATE_FORM . '.js');
        $this->view->categories = $categoriesMapper->fetchAll();

        if($category_id){
            $this->view->products = $productMapper->getDbTable()->fetchAll($productMapper->getDbTable()->select()->where('category_id = ?', $category_id));
        }
        else {
            $this->view->products = $productMapper->fetchAll();
        }
    }

    public function viewallAction()
    {
        $productMapper = new Application_Model_ProductMapper();

        $this->view->headScript()->appendFile(JS_DIR . '/' . self::VALIDATE_FORM . '.js');

        $this->view->form = $this->getDeleteProductForm();
        $this->view->products = $productMapper->fetchAll();

    }

    public function viewAction(){

        $id = $this->getParam('id');
        if($id){
            $productMapper = new Application_Model_ProductMapper();
            $categoriesMapper = new Application_Model_CategoryMapper();
            $this->view->categories = $categoriesMapper->fetchAll();
            $this->view->product = $productMapper->getProduct($id);;
        }
        else {
            return $this->_helper->redirector('shop');
        }
    }

    public function deleteAction(){
        $request = $this->getRequest();
        $form = $this->getDeleteProductForm();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $data = $form->getValues();
                $productMapper = new Application_Model_ProductMapper();
                if(isset($data['product_id']))  $productMapper->delete($data['product_id']);
                return $this->_helper->redirector('viewall');
            }
        }

    }

    public function getDeleteProductForm()
    {
        $form = new Zend_Form();
        $form->setMethod('post');
        $decoratorField = new My_Decorator_Field();
        $elements = array();
        //Add id hidden field

        $input = new Zend_Form_Element_Hidden('product_id');

        $min = new Zend_Validate_GreaterThan(self::MIN);

        $input->addValidators(array(new Zend_Validate_Digits(), $min, new Zend_Validate_NotEmpty()));
        $elements[] = $input;


        //Add Submit button
        $input = new Zend_Form_Element_Submit('submit',array(
            'Label'      => '',
            'class'      => 'btn btn-danger',
            'value'      => 'Delete',
        ));
        $elements[] = $input;
        $input->addDecorator($decoratorField);
        $form->addElements($elements);


        return $form;
    }

    public function saveAction(){
        $request = $this->getRequest();
        $id = $this->getParam('id');

        $form = $this->getSaveProductForm($id);

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $data = $form->getValues();

                $upload = new Zend_File_Transfer();

                $files = $upload->getFileInfo();
                $isValid = true;

                foreach ($files as $field => $file)
                {
                    if(!strlen($file["name"]))
                    {
                        continue;
                    }

                    // upload instructions for image
                    if ($field == 'image')
                    {
                        $upload->addFilter('Rename', array('target' => UPLOADS_IMAGES . '/' . $file['name'], 'overwrite' => TRUE), $field)
                               ->addValidator('Extension', false, array('jpg', 'jpeg', 'png'), $field);
                        $data['image'] = $file['name'];
                    }

                    // upload instructions for file
                    if ($field == 'file')
                    {
                        $upload->addFilter('Rename', array('target' => UPLOADS_DATA . '/' . $file['name'], 'overwrite' => TRUE), $field)
                               ->addValidator('Extension', false, array('doc', 'docx', 'txt', 'pdf'), $field);
                        $data['file'] = $file['name'];
                    }



                    if($upload->isValid($field)) {
                        if (!$upload->receive($field)) {
                            echo '<h1>Oops</h1><p>Please correct the following errors: <hr /></p>';

                            foreach ($upload->getMessages() as $key => $val) {
                                echo '<p><strong>' . $key . '</strong><br />' . $val . '</p>';
                            }
                            die;
                            //return;
                        }
                    }
                    else {
                        $isValid = false;
                        echo 'Is not valid ' . $field;
                    }
                }

                if ($upload->hasErrors()) {
                    $errors = $upload->getMessages();
                    var_dump($errors);
                }

                if($isValid){
                    //var_dump($form->getValues());
                    $product = new Application_Model_Product($data);
                    $mapper = new Application_Model_ProductMapper();
                    $mapper->save($product);
                    return $this->_helper->redirector('viewall');
                }
//                return $this->redirect()->toRoute('upload-form/success');
            }
        }

        $this->view->headScript()->appendFile(JS_DIR . '/' . self::DELETE_FIELD . '.js');

        $this->view->form = $form;
    }

    public function getSaveProductForm($id)
    {

        $form = new Zend_Form();

        //get product whitch want update
        $productMapper = new Application_Model_ProductMapper();
        $product = new Application_Model_Product();

        if ( $id ) $product = $productMapper->getProduct($id);

        // Set the method for the display form to POST
        $form->setMethod('post');
        $form->setAttribs(
            array(
                'class' => 'form-horizontal' ,
                'enctype' => 'multipart/form-data' ,
            )
        );

        $decoratorField = new My_Decorator_Field();

        $elements = array();
        //Add id hidden field
        $input = new Zend_Form_Element_Hidden('id',array('value' => $id));
        $elements[] = $input;

        // Add name field
        $input = new Zend_Form_Element_Text('name',array(
            'required'   => true,
            'label'      => 'Name:',
            'id'         => 'name',
            'placeholder'=> 'Type something..',
            'value'      =>  $product->getName(),
            'class'      => 'form-control',
        ));

        $input->addValidators(array(new Zend_Validate_Alnum(),new Zend_Validate_NotEmpty()));
        $input->addDecorator($decoratorField);
        $elements[] = $input;

        // Add category field
        $select = new Zend_Form_Element_Select('category_id',array(
            'required'   => true,
            'label'      => 'Category:',
            'id'         => 'category',
            'class'      => 'form-control',
        ));

        $categoryMapper = new Application_Model_CategoryMapper();
        $categories = $categoryMapper->fetchAll();
        foreach($categories as $category){
            $select->addMultiOption($category->getId(), $category->getName());
        }
        // set selected option
        $select->setValue($product->getCategoryId());

        $select->addDecorator($decoratorField);
        $elements[] = $select;

        // Add Price field
        $input = new Zend_Form_Element_Text('price',array(
            'required'   => true,
            'label'      => 'Price:',
            'id'         => 'price',
            'placeholder'=> 'Type something..',
            'value'      =>  number_format($product->price, 2),
            'class'      => 'form-control',
            'min'        => self :: MIN,
            'max'        => self :: MAX,
            'step'       => 'any',
            'type'       => 'number',
        ));

        $min = new Zend_Validate_LessThan(self::MAX);
        $max = new Zend_Validate_GreaterThan(self::MIN);

        $input->addValidators(array(new Zend_Validate_Float(), $min, $max, new Zend_Validate_NotEmpty()));
        $input->addDecorator($decoratorField);
        $elements[] = $input;

        if($id) {
            //Add File field
            $input = new Zend_Form_Element('file', array(
                'label' => 'File:',
                'id' => 'file',
                'class' => 'form-control',
                'value' => $product->file,
            ));
            $input->addDecorator(new My_Decorator_AnchoraForm());
            $elements[] = $input;

            //Add Image field
            $input = new Zend_Form_Element('image', array(
                'label' => 'Image:',
                'id' => 'image',
                'class' => 'form-control',
                'value' => $product->image,
            ));

            $input->addDecorator(new My_Decorator_ImageForm());
            $elements[] = $input;

        } else {
            //Add File field
            $input = new Zend_Form_Element_File('file', array(
                'label' => 'File:',
                'id' => 'file',
                'class' => 'form-control',
            ));

            $input->addDecorator($decoratorField);
            $elements[] = $input;

            //Add Image field
            $input = new Zend_Form_Element_File('image', array(
                'label' => 'Image:',
                'id' => 'image',
                'class' => 'form-control',
            ));

            $input->addDecorator($decoratorField);
            $elements[] = $input;

        }

        //Add Description field
        $input = new Zend_Form_Element_Textarea('description', array(
            'label' => 'Description:',
            'id' => 'description',
            'class' => 'form-control',
            'value' => $product->description,
        ));


        $input->addDecorator($decoratorField);
        $elements[] = $input;

        //Add Submit button
        if(!$id) {
            $input = new Zend_Form_Element_Submit('submit',array(
                'Label'      => '',
                'class'      => 'btn btn-success',
                'value'      => 'Add New Product',
            ));
        }
        else {
            $input = new Zend_Form_Element_Submit('submit',array(
                'Label'      => '',
                'class'      => 'btn btn-info',
                'value'      => 'Update Product',
            ));
        }

        $input->addDecorator($decoratorField);
        $elements[] = $input;


        $form->addElements($elements);

        $form->addDisplayGroup(
            array('name', 'category_id' ,'price', 'file', 'image' ,'description','submit'),
            'displgrp',
            array(
                'legend' => 'Add Products',
                'decorators' => array(
                    'FormElements',
                    'Fieldset',
                    /*// need to alias the HtmlTag decorator so you can use it twice
                    array(array('Dashed'=>'HtmlTag'), array('tag'=>'div', 'class'=>'dashed-outline')),
                    array('HtmlTag',array('tag' => 'div',  'class' => 'settings')),*/
                )
            )
        );

        return $form;
    }


}

