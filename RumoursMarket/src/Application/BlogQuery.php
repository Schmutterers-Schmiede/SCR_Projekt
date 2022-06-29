<?php

namespace Application;

class BlogQuery {
    public function __construct(
        private \Application\Interfaces\BlogRepository $blogRepository
        
    ) {}

    public function execute (int $userId) : array {
        $blogEntries = $this->blogRepository->getBlogsForUser($userId);
         return $blogEntries;
    }
}