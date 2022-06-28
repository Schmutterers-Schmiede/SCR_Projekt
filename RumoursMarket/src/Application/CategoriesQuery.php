<?php
namespace Application;

class CategoriesQuery {
    public function __construct(
        private Interfaces\CategoryRepository $categoryRepository
    )
    {}

    public function execute() : array {//of Data Objects (is imma so)
        // Entity aus Repository holen -> Entity in Data Object umwandlen -> view zusammenbauen
        $res = [];
        $categories = $this->categoryRepository->getCategories();
        foreach ($categories as $c) {
            $res[] = new CategoryData($c->getId(), $c->getName());
        }
        return $res;
    }
}