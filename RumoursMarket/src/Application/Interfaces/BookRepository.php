<?php

namespace Application\Interfaces;

interface BookRepository {
    public function getBooksForCategory(int $categoryId): array; // of Book entity
}