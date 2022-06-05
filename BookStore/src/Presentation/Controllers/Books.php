<?php

namespace Presentation\Controllers;

class Books extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\BooksQuery $booksQuery,
        private \Application\CategoriesQuery $categoriesQuery,
        private \Application\SignedInUserQuery $signedInUserQuery
        )
    { }

    public function GET_Index(): \Presentation\MVC\ActionResult {
        return $this->view('bookList', [
            'user' => $this->signedInUserQuery->execute(),
            'categories'  => $this->categoriesQuery->execute(),
            'selectedCategoryId' => $this->tryGetParam('cid', $value) ? $value : null,
            'books' => $this->tryGetParam('cid', $value) ? $this->booksQuery->execute($value) : null,
            'returnUrl' => $this->getRequestUri()
        ]);
    }
}