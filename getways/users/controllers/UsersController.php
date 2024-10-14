<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\ChargeWalletRequest;
use getways\users\requests\CreateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    /*************************admins*************************/
    public function createUser(CreateUserRequest $request)
    {
        return loadGetway('users')->CreateUser($request->validated());
    }

    public function userFind($userId)
    {
        return loadGetway('users')->userFind($userId);
    }

    public function allStores(Request $request)
    {
        return loadGetway('users')->allStores($request->all());
    }

    public function allUsers(Request $request)
    {
        return loadGetway('users')->allUsers($request->all());
    }

    public function deleteUser($userId)
    {
        return loadGetway('users')->deleteUser($userId);
    }

    public function active($id)
    {
        return loadGetway('users')->avtivateUser($id);
    }

    public function block($userId, Request $request)
    {
        return loadGetway('users')->BlockUser($userId, $request->reason);
    }
    /*************************users*************************/


    public function chargeWallet(ChargeWalletRequest $request)
    {
        $data = [
            'user'=>Auth::guard('user')->user(),
            'request'=>$request,
            'validate'=>$request->validated()
        ];
        return loadGetway('users')->ChargeUserWallet($data);
    }
    public function Wallet(Request $request)
    {
        $data = [
            'user'=>Auth::guard('user')->user(),
            'request'=>$request,
        ];
        return loadGetway('users')->userWallet($data);
    }
    public function WalletActions(Request $request)
    {
        $data = [
            'user'=>Auth::guard('user')->user(),
            'request'=>$request,
        ];
        return loadGetway('users')->userWalletAction($data);
    }
    public function currency()
    {
        $data = [
            'user'=>Auth::guard('user')->user(),
        ];
        return loadGetway('users')->currency($data);
    }
    public function transactions(Request $request)
    {
        $user=Auth::guard('user')->user();
        return loadGetway('users')->UserTransaction($request,$user);
    }

    public function branches(Request $request)
    {
        return loadGetway('users')->branches($request);
    }

}
