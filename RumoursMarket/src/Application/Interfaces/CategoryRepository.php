<?php

namespace Application\Interfaces;

interface CategoryRepository {
    public function getCategories() : array; //of Category entities
}