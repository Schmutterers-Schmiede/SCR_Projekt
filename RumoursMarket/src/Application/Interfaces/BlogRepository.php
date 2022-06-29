<?php

namespace Application\Interfaces;

interface BlogRepository {
    public function getBlogsForUser(int $userId) : array;
}
