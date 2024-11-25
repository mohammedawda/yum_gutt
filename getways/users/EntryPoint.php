<?php

namespace getways\users;

use getways\users\logic\Admin;
use getways\users\logic\authentication\Login;
use getways\users\logic\authentication\Logout;
use getways\users\logic\authentication\Register;
use getways\users\logic\authentication\ResetPassword;
use getways\users\logic\authentication\UserVerification;
use getways\users\logic\user\CreateUser;
use getways\users\logic\user\Profile;
use getways\users\logic\user\BaseUser;
use getways\users\logic\user\ListUsers;
use getways\users\logic\user\UpdateUser;
use getways\users\logic\user\UserDestroy;
use getways\users\logic\user\UserDetails;
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

    public function login($login_data)
    {
        return (new Login(new AuthRepository()))->login($login_data);
    }

    public function admin_login(array $login_data)
    {
        $login_obj = new Login(new AuthRepository());
        return $login_obj->admin_login($login_data);
    }
    
    public function logout()
    {
        return (new Logout(new AuthRepository()))->logout();
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

    /************************admins************************/
    public function CreateUser(array $data)
    {
        return (new CreateUser(new UserRepository()))->CreateUser($data);
    }

    public function updateUser($userId, array $data)
    {
        return (new UpdateUser(new UserRepository()))->updateUser($userId, $data);
    }

    public function allStores($filter)
    {
        return (new ListUsers(new UserRepository()))->allStores($filter);
    }

    public function allAdmins($filter)
    {
        return (new ListUsers(new UserRepository()))->allAdmins($filter);
    }

    public function allUsers($filter)
    {
        return (new ListUsers(new UserRepository()))->allUsers($filter);
    }

    public function userFind($userId)
    {
        return (new UserDetails(new UserRepository()))->userFind($userId);
    }

    public function deleteUser($userId) 
    {
        return (new UserDestroy(new UserRepository()))->deleteUser($userId);
    }

    public function avtivateUser($id)
    {
        return (new BaseUser(new UserRepository()))->activateUser($id);
    }

    public function BlockUser($userId, $reason)
    {
        return (new BaseUser(new UserRepository()))->block_user($userId, $reason);
    }

    /************************profiles************************/
    public function storeProfile()
    {
        return (new Profile(new UserRepository()))->storeProfile();
    }

    public function userProfile()
    {
        return (new Profile(new UserRepository()))->userProfile();
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
        $user_obj = new BaseUser(new UserRepository());
        return $user_obj->chargeWallet($data);
    }
    public function userWallet(array $data)
    {
        $user_obj = new BaseUser(new UserRepository());
        return $user_obj->userWallet($data);
    }
    public function userWalletAction(array $data)
    {
        $user_obj = new BaseUser(new UserRepository());
        return $user_obj->userWalletAction($data);
    }
    public function currency(array $data)
    {
        $user_obj = new BaseUser(new UserRepository());
        return $user_obj->Currency($data);
    }

    public function branches($request)
    {
        $user_obj = new BaseUser(new UserRepository());
        return $user_obj->branches($request);
    }
    public function UserTransaction($request,$user)
    {
        $user_obj = new BaseUser(new UserRepository());
        return $user_obj->Transactions($request,$user);
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
