<?php

namespace Presentation\Controllers;

class Users extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\UsersQuery $usersQuery,
        private \Application\SignedInUserQuery $signedInUserQuery
    ) {}

    public function GET_Index(): \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();

        if($user === null) {
            return $this->redirect('User', 'LogIn');    // WIRD BEI PROJEKT GEPRÜFT !!!
        }
        
        return $this->view('userList', [
            'user' => $this->signedInUserQuery->execute(),
            'users' => $this->usersQuery->execute()
        ]);
    }
}