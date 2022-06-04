<?php

namespace Presentation\Controllers;

class Order extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\CheckOutCommand $checkOutCommand,
    )
    { }

    public function GET_Create() : \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();

        if($user === null) {
            return $this->redirect('User', 'LogIn');    // WIRD BEI PROJEKT GEPRÜFT !!!
        }
        // show form to place order
        return $this->view('orderForm', [
            'user' => $user,
            'cartSize' => 0, //TODO - homework
            'nameOnCard' => '',
            'cardNumber' => ''
        ]);
    }

    public function POST_Create() : \Presentation\MVC\ActionResult {
        // place order now and redirect (or show errors)
        $ccName = $this->getParam('noc');
        $ccNumber = $this->getParam('cn');
        $result = $this->checkOutCommand->execute($ccName, $ccNumber, $orderId);
        if ($result != 0) {
            // error situation
            $errors = ['Something went wrong!'. $result];
            // TODO: Improve Errors z.B.: if(§result & \Application\CheckOutCommand:ErrorNotAutenticated) {
            //     $errors[] = 'User must be authenticated';
            // }
            return $this->view('orderForm', [
                'user' => $this->signedInUserQuery->execute(),
                'cartSize' => 0, //TODO - homework - introduce new CartSizeQuery and execute it here
                'nameOnCard' => $ccName,
                'cardNumber' => $ccNumber,
                'errors' => $errors
            ]);
        }
        // sucess > redirect 
        return $this->redirect('Order', 'Summary', ['oid' => $orderId]);
    }

    public function GET_Summary(): \Presentation\MVC\ActionResult {
        //TODO: execute "OrderSummaryQuery" with order ID here and then render order summary
        return $this->view('orderSummary', [
            'user' => $this->signedInUserQuery->execute(),
            'orderId' => $this->getParam('oid')
        ]);
    }
}