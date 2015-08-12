<?php

class Zend_View_Helper_DangerError extends Zend_View_Helper_Abstract
{
    public function error ()
    {
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
        return $flashMessenger->getMessage();
    }
}