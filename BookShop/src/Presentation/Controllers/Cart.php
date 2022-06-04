<?php

namespace Presentation\Controllers;

class Cart extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\AddBookToCartCommand $addBookToCartCommand,
        private \Application\RemoveBookFromCartCommand $removeBookFromCartCommand
    )
    { }

    public function POST_Add(): \Presentation\MVC\ActionResult {
        $this->addBookToCartCommand->execute($this->getParam('bid'));
        // Redirect wegen POST
        return $this->redirectToUri($this->getParam('returnUrl'));
    }
    
    public function POST_Remove(): \Presentation\MVC\ActionResult {
        $this->removeBookFromCartCommand->execute($this->getParam('bid'));
        return $this->redirectToUri($this->getParam('returnUrl'));
    }
}