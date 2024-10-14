<?php

namespace getways\users\repositories;

use App\Support\Factory\Payment\ChargeWalletPayment;
use Carbon\Carbon;
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

    public function deleteUserByObject($user)
    {
        return $user->delete();
    }

    public function getUserByLoginData($loginType, $credentials, $rols)
    {
        $countryId = config('app.country_id');
        return User::where($loginType, $credentials[$loginType])->where('country_id', $countryId)->whereIn('role_id', $rols)->first();
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

    public function allUsers($filter, $with = [], $userType)
    {
        return getTakedPreparedCollection( 
            User::CountryId()->$userType()
            ->when(isset($filter['national_id']), function($query) use($filter) {
                $query->where('national_id', 'LIKE', '%' . $filter['national_id'] . '%');
            })
            ->when(isset($filter['status']), function($query) use($filter){
                $query->where('status', $filter['status']);
            })
            ->when(!empty($filter['name']), function($query) use($filter) {
                $query->where('name', 'LIKE', '%' . $filter['name'] . '%');
            })
            ->when(!empty($filter['email']), function($query) use($filter) {
                $query->where('email', 'LIKE', '%' . $filter['email'] . '%');
            })
            ->when(!empty($filter['phone']), function($query) use($filter) {
                $query->where('phone', 'LIKE', '%' . $filter['phone'] . '%');
            })
            ->when(!empty($filter['created_at_from']), function($query) use($filter) {
                $query->whereDate('created_at', '>=', $filter['created_at_from']);
            })
            ->when(!empty($filter['created_at_to']), function($query) use($filter) {
                $query->whereDate('created_at', '>=', $filter['created_at_to']);
            })
            ->with($with), $filter
        );
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

    public function updateUserByObject($user, $update)
    {
        return $user->update($update);
    }

}
