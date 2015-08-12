<?php

class MailsettingsController extends Zend_Controller_Action{

    public function indexAction(){
        $mailMapper = new Application_Model_MailsettingMapper();
        $mailSetting = $mailMapper->getConfig();
        var_dump($mailSetting);
    }

    public function addAction(){
        $form = new Application_Form_MailSetting();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $data = $form->getValues();
                $obj = new My_Class_Cript();
                $data['password'] = $obj->cript($data['password1']);
                unset($data['password1']);
                unset($data['password2']);
                $json = json_encode($data);
                $mailMapper = new Application_Model_MailsettingMapper();
                $mailMapper->add($json);

                $this->_helper->redirector('index');
            }
            else {
                var_dump($form->getMessages());
            }
        }
        $this->view->form = $form;
    }
}