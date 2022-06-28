<?php

namespace Application;

class AddBookToCartCommand {    // nach jedem Command wird redirectet (wegen POST request)
    public function __construct(
        private Services\CartService $cartService
    )
    { }

    public function execute(int $bookId): void {
        $this->cartService->addBook($bookId);
    }
}