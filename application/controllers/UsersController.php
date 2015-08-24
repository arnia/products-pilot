<?php

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;


class UsersController extends Zend_Controller_Action {

    const MIN = 0;
    const MAX = 5000;
    const DELETE_FROM_CART = 'delFromCart';
    const VALIDATE_FORM = 'validateForm';
    const COUNT_CART = 'countCart';
    const ADD_TO_CART = 'addToCart';
    const PROCESS_PAYMENT = 'processPayment';


    public function indexAction() {
        return $this->_helper->redirector('login', 'auth');
    }

    public function dashboardAction() {

        $this->view->headScript()->appendFile(JS_DIR . '/' . self::VALIDATE_FORM . '.js');

        $productMapper = new Application_Model_ProductMapper();
        $this->view->form = new Application_Form_DeleteProduct();
        $this->view->products = $productMapper->fetchAll();

        $userMapper = new Application_Model_UserMapper();
        $this->view->users = $userMapper->fetchAll();

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->currentUser = $auth->getIdentity()->email;
        }
    }

    public function mycartAction() {

        $categoriesMapper = new Application_Model_CategoryMapper();
        $this->view->categories = $categoriesMapper->fetchAll();

        $this->view->headScript()->appendFile(JS_DIR . '/' . self::PROCESS_PAYMENT . '.js');
        $this->view->headScript()->appendFile(JS_DIR . '/' . self::DELETE_FROM_CART . '.js');
        $this->view->headScript()->appendFile(JS_DIR . '/' . self::COUNT_CART . '.js');
        $this->view->headScript()->appendFile(JS_DIR . '/' . self::ADD_TO_CART . '.js');

        $userMapper = new Application_Model_UserMapper();
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) $user_id = $auth->getIdentity()->id;

        //var_dump($userMapper->getShoppingCart($user_id));

        $this->view->shoppingcart = $userMapper->getShoppingCart($user_id);
        $forms = array();
        foreach($this->view->shoppingcart as $i => $product){
            $upForm = new Application_Form_UpdateCart();
            $upForm->setAction( $this->view->url(array('controller' => 'users','action' => 'updatecart'), null, true))
                 ->setName ("upForm$i");
            $upForm->getElement('product_id')->setValue($product->id);
            $upForm->getElement('quantity')->setValue($product->quantity);
            $forms['upForm'][] = $upForm;

            $delForm = new Application_Form_DelFromCart();
            $delForm->setAction( $this->view->url(array('controller' => 'users','action' => 'delfromcart'), null, true))
                ->setName ("delForm$i");
            $delForm->getElement('product_id')->setValue($product->id);
            $forms['delForm'][] = $delForm;
        }

        $this->view->forms = $forms;

        $this->view->delForm = new Application_Form_DelFromCart();

        $this->_helper->layout->setLayout('shop');
    }

    public function updatecartAction() {
        $request = $this->getRequest();
        $form = new Application_Form_UpdateCart();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                $user_id = '';
                if($auth->hasIdentity()) $user_id = $auth->getIdentity()->id;

                $dbAdapter = Zend_Db_Table::getDefaultAdapter();

                $dbAdapter->update('shoppingcarts', array('quantity' => $data['quantity']), array('user_id = ?' => $user_id, 'product_id = ?' => $data['product_id']));
                //var_dump($user_id, $data);
                return $this->_helper->redirector('mycart');
            } else {
                foreach ($form->getMessages() as $error){
                    $this->_helper->getHelper('FlashMessenger')->addMessage(array_shift(array_values($error)), 'error');
                    $this->_helper->redirector('mycart');
                }
            }
        }

    }

    public function delfromcartAction() {
        $request = $this->getRequest();
        $form = new Application_Form_DelFromCart();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                $user_id = '';
                if($auth->hasIdentity()) $user_id = $auth->getIdentity()->id;

                $dbAdapter = Zend_Db_Table::getDefaultAdapter();

                $dbAdapter->delete('shoppingcarts', array('user_id = ?' => $user_id, 'product_id = ?' => $data['product_id']));
                //var_dump($user_id, $data);
                return $this->_helper->redirector('mycart');
            } else {
                foreach ($form->getMessages() as $error){
                    $this->_helper->getHelper('FlashMessenger')->addMessage(array_shift(array_values($error)), 'error');
                    $this->_helper->redirector('mycart');
                }
            }
        }
    }

    public function deleteAction() {

    }

    public function paypalAction() {


        //Zend_Loader::loadFile('paypal_bootstrap.php', APPLICATION_PATH . "/../library/My/", true);

        require (APPLICATION_PATH . "/../library/My/paypal_bootstrap.php");

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) $user_id = $auth->getIdentity()->id;
        else return;

        $userMapper = new Application_Model_UserMapper();
        $results = $userMapper->getShoppingCart($user_id);
        $items = array();
        $subTotal = 0;
        foreach($results as $i => $result) {
            $item = new Item();
            $item->setName($result->name)
                ->setCurrency('USD')
                ->setQuantity($result->quantity)
                ->setSku($i + 1) // Similar to `item_number` in Classic API
                ->setPrice($result->price);
            $items[] = $item;
            $subTotal += $result->quantity * (float)number_format($result->price,2);
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $shippingTax = 1; //

        $details = new Details();
        $details->setShipping($shippingTax)
                ->setTax(0)
                ->setSubtotal($subTotal);
        $total = $shippingTax + $subTotal;

        $amount = new Amount();
        $amount->setCurrency("USD")
                ->setTotal($total)
                ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription("Payment description")
                    ->setInvoiceNumber(uniqid());

        $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl . '/users/exepaypal/?success=true');
        $redirectUrls->setCancelUrl($baseUrl .'/users/exepaypal/?cancel=true');

        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $result = $payment->create($apiContext);

        //var_dump($result);

        $response = array(
            'error' => 'false',
            'approvalLink' => $payment->getApprovalLink()
        );

        /* Send as JSON */
        header("Content-Type: application/json", true);

        /* Return JSON */
        echo json_encode($response);

        /* Stop Execution */
        exit;

    }

    public function exepaypalAction(){
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            $paymentId = $_GET['paymentId'];
            $token = $_GET['token'];
            $PayerID = $_GET['PayerID'];

            Zend_Loader::loadFile('paypal_bootstrap.php', APPLICATION_PATH . "/../library/My/", true);

            $cred = new OAuthTokenCredential(
                "ASoFp5N8bjs0m3Czfyqocy9o_6ZuZOEQMaM1PB8H1h4uTFPYgPFePfIjBvruMIwUrZ9jtV1RLS7PGqIM",
                "ECk662STXzf0U4aXr_JgHWxDjXVsPMCQQN2BTDTCRqvotxnub2kD-3dHqhj9z1-TxHgf0KQpY9c0vCXv");
            $apiContext = new ApiContext($cred, 'Request' . time());

            $payment = Payment::get($paymentId, $apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($PayerID);

            $result = $payment->execute($execution, $apiContext);

            $payment = Payment::get($paymentId, $apiContext);

            var_dump($payment);

        }


    }
}