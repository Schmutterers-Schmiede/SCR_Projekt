<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\AddUserCommand $addUserCommand
        )
        {          
        }

    public function GET_LogIn(): \Presentation\MVC\ActionResult {
        return $this->view('login', [
            'user' => $this->signedInUserQuery->execute(),
            'login' => ''    // weil erstmaliger Aufruf der Login Page // '' <=> null <=> 0
        ]);
    }

    public function POST_LogIn(): \Presentation\MVC\ActionResult {
        // Try to authenticate given uer
        if(!$this->signInCommand->execute($this->getParam('ln'), $this->getParam('pwd'))) {
            // authentication failed - nothing has changed, show view with error informaion
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'login' => $this->getParam('ln'),
                'errors' => [ 'Invalid user name or password.' ]
            ]);
        }
        return $this->redirect('Home', 'Index'); // TODO - make this better wit return Url - same as wit Cart>Add
    }

    public function POST_LogOut(): \Presentation\MVC\ActionResult {
        // sign out current user
        $this->signOutCommand->execute();
        return $this->redirect('Home', 'Index'); // TODO - make this better wit return Url - ame as wit Cart>Add
    }

    public function GET_AddUser(): \Presentation\MVC\ActionResult {
        return $this->view('adduser', [
            'user' => $this->signedInUserQuery->execute(),
            'login' => '',
            'userName' => '',    // weil Neuer User // '' <=> null <=> 0
            'password' => '',    // weil Neuer User // '' <=> null <=> 0
            'confirmPassword' => '' // weil Neuer User // '' <=> null <=> 0
        ]);
    }

    public function POST_AddUser(): \Presentation\MVC\ActionResult {
        $usrerror = $this->addUserCommand->execute($this->getParam('ln'), $this->getParam('un'), $this->getParam('pwd'), $this->getParam('cfpwd'));
        if( $usrerror > 0) {
            $errMsg[] = 'Invalid user name or password.';

            if($usrerror & 0x01) {
                $errMsg[] = 'Username is empty';
            }
            if($usrerror & 0x02) {
                $errMsg[] = 'Password missing';
            }
            if($usrerror & 0x04) {
                $errMsg[] = 'Passwords not equal';
            }
            if($usrerror & 0x10) {
                $errMsg[] = 'User not savd';
            }

            return $this->view('adduser', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'password' => '',
                'confirmPassword' => '',
                'errors' => $errMsg
            ]);
        }
        return $this->redirect('Home', 'Index'); // TODO - make this better wit return Url - ame as wit Cart>Add
    }
}