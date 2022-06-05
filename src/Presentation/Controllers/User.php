<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand,
        private \Application\SignedInUserQuery $signedInUserQuery
        )
        {
            
        }

    public function GET_LogIn(): \Presentation\MVC\ActionResult {
        return $this->view('login', [
            'user' => $this->signedInUserQuery->execute(),
            'userName' => ''    // weil erstmaliger Aufruf der Login Page // '' <=> null <=> 0
        ]);
    }

    public function POST_LogIn(): \Presentation\MVC\ActionResult {
        // Try to authenticate given uer
        if(!$this->signInCommand->execute($this->getParam('un'), $this->getParam('pwd'))) {
            // authentication failed - nothing has changed, show view with error informaion
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => [ 'Invalid user name or password.' ]
            ]);
        }
        return $this->redirect('Home', 'Index'); // TODO - make this better wit return Url - ame as wit Cart>Add
    }

    public function POST_LogOut(): \Presentation\MVC\ActionResult {
        // sign out current user
        $this->signOutCommand->execute();
        return $this->redirect('Home', 'Index'); // TODO - make this better wit return Url - ame as wit Cart>Add
    }

}