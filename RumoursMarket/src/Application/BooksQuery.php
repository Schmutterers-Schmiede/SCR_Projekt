<?php

namespace Application;
// Entwurfsmuster: CQRS

class BooksQuery {
    public function __construct(
        private \Application\Interfaces\BookRepository $bookRepository,
        private Services\CartService $cartService
    )
    { }

    public function execute(string $categoryId) : array {   // of Book Data
        $books = $this->bookRepository->getBooksForCategory($categoryId);   // Book Entities
        $res = [];
        foreach($books as $b) {
            $res[] = new BookData($b->getId(), $b->getTitle(), $b->getAuthor(),
                                  $b->getPrice(), $this->cartService->getCountForBook($b->getId())); //TODO cartcount
        }
        return $res;
    }
    // http://localhost/BookShop/index.php?c=Books&cid=1
}