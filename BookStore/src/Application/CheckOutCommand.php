<?php

namespace Application;

class CheckOutCommand {
    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Services\CartService $cartService,
        private Interfaces\OrderRepository $orderRepository
    )
    {
        
    }
    
    const Error_NotAuthenticated = 0x01;
    const Error_CartEmpty = 0x02;
    const Error_InvalidCreditCardName = 0x04;
    const Error_InvalidCreditCardNumber = 0x08;
    const Error_CreatedOrderFailed = 0x10;  // Hexadezimal = dezimal 16
    // Error Bits (kann später mit einer Bitmask verglichen werden)

    public function Execute($creditCardName, string $creditCardNumber, ?int &$orderId): int {   // reference Paramenter &$orderId
        $creditCardName = trim($creditCardName);                        // entfernt hinten und vorne Leerzeichen
        $creditCardNumber = str_replace(' ', '', $creditCardNumber);    //ersetzt Leerzeichen
        
        $orderId = null;
        $errors = 0;

        // check for authenticated user (security first)
        $userId = $this->authenticationService->getUserid();
        if ($userId === null) {
            $errors |= self ::Error_NotAuthenticated;   //Bitweises Oder Operation
        }
        // check Items in Cart
        $cart = $this->cartService->getBooksWithCount();
        if (sizeof($cart) == 0) {
            $errors |= self::Error_CartEmpty;
        }
        // check privided data(CC etc.)
        if(strlen($creditCardName) == 0) {
            $errors |= self::Error_InvalidCreditCardName;
        }
        if (strlen($creditCardNumber) != 16 || !ctype_digit($creditCardNumber)) { //checktype
            $errors |= self::Error_InvalidCreditCardNumber;
        }
        if($errors) {   // 0 <=> false      1 <=> true
            return $errors;
        }

        // try to create new order
        $orderId = $this->orderRepository->createOrder($userId, $cart, $creditCardName, $creditCardNumber);
        if ($orderId == null) {
            return self::Error_CreatedOrderFailed;
        }

        // clear cart on success
        $this->cartService->clear();
        return 0;
    }
}