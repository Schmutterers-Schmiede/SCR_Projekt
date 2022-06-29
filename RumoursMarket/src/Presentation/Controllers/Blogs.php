<?php

namespace Presentation\Controllers;

class Blogs extends \Presentation\MVC\Controller {
    public function __construct (
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\BlogQuery $blogQuery
    ) {}

    public function GET_Index(): \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();
    
        if($user === null) {
            return $this->redirect('User', 'LogIn');    // WIRD BEI PROJEKT GEPRÜFT !!!
        }

        return $this->view('blogList', [
            'user' => $this->signedInUserQuery->execute(),
            'blogEntries' => $this->blogQuery->execute($user->getId())
        ]);
    }
}