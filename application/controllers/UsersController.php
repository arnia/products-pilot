<?php

class UsersController extends Zend_Controller_Action {

    const MIN = 0;
    const MAX = 5000;
    const VALIDATE_FORM = 'validateForm';

    public function indexAction()
    {
        return $this->_helper->redirector('login', 'auth');
    }

    public function dashboardAction(){

        $this->view->headScript()->appendFile(JS_DIR . '/' . self::VALIDATE_FORM . '.js');

        $productMapper = new Application_Model_ProductMapper();
        $this->view->form = $this->getDeleteProductForm();
        $this->view->products = $productMapper->fetchAll();

        $userMapper = new Application_Model_UserMapper();
        $this->view->users = $userMapper->fetchAll();

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->currentUser = $auth->getIdentity()->email;
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
}