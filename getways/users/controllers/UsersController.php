<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use App\Mail\ProcessingDocumentEmail;
use App\Mail\ReceivedDocumentEmail;
use App\Mail\VerifyEmail;
use getways\users\models\User;
use getways\users\requests\AnswerRequest;
use getways\users\requests\ChargeWalletRequest;
use getways\users\requests\CreateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        $validate = $request->validated();
        $validate['status'] = '1';
        return loadGetway('users')->CreateUser($validate);
    }

    public function active($id)
    {
        return loadGetway('users')->avtivateUser($id);
    }

    public function block(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'reason'=>$request->reason
        ];
        return loadGetway('users')->BlockUser($data);
    }
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

    public function userQuestion(Request $request)
    {
        return loadGetway('users')->userQuestion($request);
    }
    public function branches(Request $request)
    {
        return loadGetway('users')->branches($request);
    }
    public function userAnswer(AnswerRequest $request)
    {
        return loadGetway('users')->answer($request);
    }

}
