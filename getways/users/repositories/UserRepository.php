<?php

namespace getways\users\repositories;

use App\Support\Factory\Payment\ChargeWalletPayment;
use Carbon\Carbon;
use getways\users\models\Question;
use getways\users\models\User;
use getways\users\models\WalletTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function create_user(array $data)
    {
        return User::create($data);
    }

    public function get_user_data($id)
    {
        return User::find($id);
    }

    public function get_user_dataByEmail($email,$country_id)
    {
        return User::whereEmail($email)->where('country_id',$country_id)->first();
    }

    public function updateUserStatus($user, $status)
    {
        return $user->update([
            'status'    => $status,
            'action_by' => Auth::user()->id,
            'action_at' => Carbon::now()
        ]);
    }

    public function userWalletAction($request,$user)
    {
        $rows = getSkipTake($request);
        $wallet = $user->wallets()->orderByDesc('id')
            ->when($request->type, function($query) use ($request) {
                $query->where('type',$request->type);
            })
        ;
        $criteria['total'] = $wallet->count();
        $criteria['list']  = $wallet->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function userTransaction($request,$user)
    {
        $rows = getSkipTake($request);
        $transactions = $user->transactions()->orderByDesc('id');
        $transactions = $transactions
            ->when($request->type, function($query) use ($request) {
                $query->where('type',$request->type);
            })
        ;
        $criteria['total'] = $transactions->count();
        $criteria['list']  = $transactions->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function storeUserAnswer($request): array
    {

        $user_id = $request->input('user_id');
        $answersData = $request->input('answers');

        return array_map(function($answerData) use ($user_id) {
            $question_type = Question::find($answerData['question_id'])->type;
            return [
                'user_id' => $user_id,
                'question_id' => $answerData['question_id'],
                'question_type' => $question_type,
                'answer' => $answerData['answer'],
            ];
        }, $answersData);

    }

    public function via_visa_mastercard($data): \Illuminate\Http\JsonResponse
    {
        $payment = new ChargeWalletPayment();
        $payment_url = $payment->generatePaymentLink($data);
        return sendResponse(true, __('The payment url.'), $payment_url);
    }

    public function via_installment($data): \Illuminate\Http\JsonResponse
    {
        $payment = new ChargeWalletPayment();
        $payment_url = $payment->generateInstallmentPaymentLink($data);
        return sendResponse(true, __('The installment payment url.'), $payment_url);
    }

    public function via_local($data): \Illuminate\Http\JsonResponse
    {
        $validate = Arr::pull($data, 'validate');
        if (array_key_exists('transfer_photo', $validate)) {
            $image = Arr::pull($validate, 'transfer_photo');
            $validate['transfer_photo'] = upload($image, 'images');
        }
        $validate['user_id'] = $data['user']->id;
        $validate['country_id'] = $data['user']->country_id;
        $validate['city_id'] = $data['user']->city_id;
        WalletTransaction::create($validate);
        return sendResponse(true, __('The transaction will be accepted by us as soon as possible.'), null);
    }

}
