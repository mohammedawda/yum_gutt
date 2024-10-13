<?php

namespace getways\users;

use getways\users\logic\Admin;
use getways\users\logic\authentication\Login;
use getways\users\logic\authentication\Logout;
use getways\users\logic\authentication\Register;
use getways\users\logic\authentication\ResetPassword;
use getways\users\logic\authentication\UserVerification;
use getways\users\logic\user\CreateUser;
use getways\users\logic\Profile;
use getways\users\logic\user\BaseUser;
use getways\users\repositories\AdminRepository;
use getways\users\repositories\AuthRepository;
use getways\users\repositories\UserRepository;

class EntryPoint
{
    /************************authentication************************/
    public function register(array $registerData)
    {
        return (new Register(new AuthRepository()))->register($registerData);
    }

    public function verify(array $data)
    {
        return (new UserVerification(new UserRepository()))->verify($data);
    }

    public function SendVerify(array $data)
    {
        return (new UserVerification(new UserRepository()))->SendVerify($data);
    }

    public function login(array $login_data)
    {
        return (new Login(new AuthRepository()))->login($login_data);
    }

    public function admin_login(array $login_data)
    {
        $login_obj = new Login(new AuthRepository());
        return $login_obj->admin_login($login_data);
    }
    
    public function logout($logout_data)
    {
        return (new Logout(new AuthRepository()))->logout($logout_data);
    }

    public function reset(array $reset_data)
    {
        $login_obj = new ResetPassword(new UserRepository());
        return $login_obj->reset($reset_data);
    }

    public function changePassword(array $reset_data)
    {
        $login_obj = new ResetPassword(new UserRepository());
        return $login_obj->change_password($reset_data);
    }

    /************************users************************/
    public function CreateUser(array $data)
    {
        return (new CreateUser(new UserRepository()))->CreateUser($data);
    }

    public function avtivateUser($id)
    {
        return (new BaseUser(new UserRepository()))->activateUser($id);
    }

    public function BlockUser(array $data)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->block_user($data);
    }

    public function profile()
    {
        $login_obj = new Profile(new AuthRepository());
        return $login_obj->profile();
    }
    public function updateProfile($request)
    {
        $login_obj = new Profile(new AuthRepository());
        return $login_obj->update_profile($request);
    }
    public function updatePassword($request)
    {
        $login_obj = new Profile(new AuthRepository());
        return $login_obj->update_password($request);
    }

    /**
     * Handles the charge user wallet request.
     *
     * @param array $data The data details.
     *
     * @param int $data['user'] The auth user model.
     * @param string $data['amount'] An aomunt the user will charge.
     */
    public function ChargeUserWallet(array $data)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->chargeWallet($data);
    }
    public function userWallet(array $data)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->userWallet($data);
    }
    public function userWalletAction(array $data)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->userWalletAction($data);
    }
    public function currency(array $data)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->Currency($data);
    }
    public function userQuestion($request)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->question($request);
    }
    public function answer($request)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->answer($request);
    }
    public function branches($request)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->branches($request);
    }
    public function UserTransaction($request,$user)
    {
        $user_obj = new User(new UserRepository());
        return $user_obj->Transactions($request,$user);
    }
    public function allUsers($request)
    {
        $user_obj = new Admin(new AdminRepository());
        return $user_obj->allUsersForAdmin($request);
    }
    public function userShow($data)
    {
        $user_obj = new Admin(new AdminRepository());
        return $user_obj->showUserForAdmin($data);
    }
    public function allUsersAnswer($request)
    {
        $user_obj = new Admin(new AdminRepository());
        return $user_obj->allUsersAnswer($request);
    }
    public function UserTransactionForAdmin($request)
    {
        $user_obj = new Admin(new AdminRepository());
        return $user_obj->Transactions($request);
    }
    public function UserTransactionBlockForAdmin($request)
    {
        $user_obj = new Admin(new AdminRepository());
        return $user_obj->TransactionBlock($request);
    }
    public function UserTransactionActiveForAdmin($request)
    {
        $user_obj = new Admin(new AdminRepository());
        return $user_obj->TransactionActive($request);
    }
}
