<?php

namespace getways\users\repositories;

use App\Support\Factory\Payment\ChargeWalletPayment;
use Carbon\Carbon;
use getways\users\models\Answer;
use getways\users\models\Question;
use getways\users\models\User;
use getways\users\models\WalletTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    public function create_user(array $data)
    {
        if (array_key_exists('nationalId_photo', $data)) {
            $image = Arr::pull($data, 'nationalId_photo');
            $data['nationalId_photo'] = upload($image, 'images');
        }
        $password = Arr::pull($data, 'password');
        $data['password'] = Hash::make($password);
        $data['password_str'] = $password;
        return User::create($data);
    }

    public function get_user_data($id)
    {
        return User::find($id);
    }

    public function get_user_dataByEmail($email)
    {
        return User::whereEmail($email)->first();
    }

    public function userQuestion($request)
    {
        $rows = getSkipTake($request);
        $questions = Question::where('status',1);
        $questions = $questions
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->type, function($query) {
                $query->orderByDesc('type');
            })
        ;
        $criteria['total'] = $questions->count();
        $criteria['list']  = $questions->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function storeUserAnswer($request)
    {

        $user_id = $request->input('user_id');
        $answersData = $request->input('answers');

        return array_map(function($answerData) use ($user_id) {
            return [
                'user_id' => $user_id,
                'question_id' => $answerData['question_id'],
                'answer' => $answerData['answer'],
            ];
        }, $answersData);

    }

    public function via_visa_mastercard($data)
    {
        $payment = new ChargeWalletPayment();
        $payment_url = $payment->generatePaymentLink($data);
        return sendResponse(true, __('The payment url.'), $payment_url);
    }

    public function via_installment($data)
    {
        $payment = new ChargeWalletPayment();
        $payment_url = $payment->generatePaymentLink($data);
        return sendResponse(true, __('The installment payment url.'), $payment_url);
    }

    public function via_local($data)
    {
        $validate = Arr::pull($data, 'validate');
        if (array_key_exists('transfer_photo', $validate)) {
            $image = Arr::pull($validate, 'transfer_photo');
            $validate['transfer_photo'] = upload($image, 'images');
        }
        $validate['user_id'] = $data['user']->id;
        WalletTransaction::create($validate);
        return sendResponse(true, __('The transaction will be accepted by us as soon as possible.'), null);
    }

    public function usersTransactions($request): array
    {
        $rows = getSkipTake($request);
        $admin_country_id = Auth::guard('admin')->user()->country_id;
        $transactions = WalletTransaction::where('country_id',$admin_country_id)->orderByDesc('id');
        $transactions = $transactions
            ->when($request->desc, function($query) {
                $query->orderBy('id', 'asc');
            })
            ->when($request->has('type'), function($query) use($request) {
                $query->where('type',$request->type);
            })
            ->when($request->has('user_id'), function($query) use($request) {
                $query->where('user_id',$request->user_id);
            })
            ->when($request->has('user_phone'), function($query) use($request) {
                $query->where('user_phone',$request->user_phone);
            })
            ->when($request->has('reference_number'), function($query) use($request) {
                $query->where('reference_number',$request->reference_number);
            })
        ;
        $criteria['total'] = $transactions->count();
        $criteria['list']  = $transactions->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function all_users($request)
    {
        $rows = getSkipTake($request);
        $admin_country_id = Auth::guard('admin')->user()->country_id;
        $users = User::where('country_id',$admin_country_id);
        $users = $users
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->first_name, function($query) use($request) {
                $query->where('first_name',$request->first_name);
            })
            ->when($request->last_name, function($query) use($request) {
                $query->where('last_name',$request->last_name);
            })
            ->when($request->email, function($query) use($request) {
                $query->where('email',$request->email);
            })
            ->when($request->phone, function($query) use($request) {
                $query->where('full_phone',$request->phone);
            })
            ->when($request->nationalId, function($query) use($request) {
                $query->where('nationalId',$request->nationalId);
            })
            ->when($request->cambain_id, function($query) use($request) {
                $query->where('cambain_id',$request->cambain_id);
            })
            ->when($request->city_id, function($query) use($request) {
                $query->where('city_id',$request->city_id);
            })
            ->when($request->has('status'), function($query) use($request) {
                $query->where('status',$request->status);
            })
            ->when($request->has('block'), function($query) use($request) {
                $query->where('block',$request->block);
            })
            ->when($request->has('created_at_from') && $request->has('created_at_to'), function($query) use($request) {
                $query->whereBetween('created_at',[$request->created_at_from,$request->created_at_to]);
            })
        ;
        $criteria['total'] = $users->count();
        $criteria['list']  = $users->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }
    public function all_usersAnswer($request)
    {
        $rows = getSkipTake($request);
        $admin_country_id = Auth::guard('admin')->user()->country_id;
        $users = User::where('country_id',$admin_country_id)
            ->when($request->user_desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->first_name, function($query) use($request) {
                $query->where('first_name',$request->first_name);
            })
            ->when($request->last_name, function($query) use($request) {
                $query->where('last_name',$request->last_name);
            })
            ->when($request->email, function($query) use($request) {
                $query->where('email',$request->email);
            })
            ->when($request->phone, function($query) use($request) {
                $query->where('phone',$request->phone);
            })
            ->when($request->nationalId, function($query) use($request) {
                $query->where('nationalId',$request->nationalId);
            })
            ->when($request->has('user_id'), function($query) use($request) {
                $query->where('id',$request->user_id);
            })
            ->when($request->cambain_id, function($query) use($request) {
                $query->where('cambain_id',$request->cambain_id);
            })->get()->pluck('id')->toArray();
        $answer = Answer::whereIn('user_id',$users);
        $criteria['total'] = $answer->count();
        $criteria['list']  = $answer->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }
    public function getWalletTransaction($id)
    {
        $transactions = WalletTransaction::find($id);
        if ($transactions->type == 0){
            return [
                'status'=>true,
                'transaction'=>$transactions
            ];
        }
        return [
            'status'=>false
        ];
    }
    public function transactionBlock($request)
    {
        $transaction = $this->getWalletTransaction($request->transaction_id);
        if ($transaction['status']){
            $transaction['transaction']->update([
                'type'=>2,
                'reason'=>$request->reason,
                'action_by'=> Auth::guard('admin')->id(),
                'action_at'=> Carbon::now()
            ]);

            return sendResponse(true, __('The transaction is rejected successfully.'),null);
        }

        return sendResponse(false, __('The transaction is not found.'),null);

    }
    public function transactionActive($request)
    {
        $transaction = $this->getWalletTransaction($request->transaction_id);
        if ($transaction['status']){
            $new_transaction = clone $transaction['transaction'];
            $transaction['transaction']->user->deposit_wallet($transaction['transaction']->amount,"The amount has been added from the bank transfer you made.");
            $new_transaction->update([
                'type'=>'1',
                'action_by'=> Auth::guard('admin')->id(),
                'action_at'=>Carbon::now()
            ]);
            return sendResponse(true, __('The transaction is completed successfully.'),null);
        }
        return sendResponse(false, __('The transaction is not found.'),null,null,500);
    }

    public function showUser($id)
    {
        return User::find($id);
    }


}
