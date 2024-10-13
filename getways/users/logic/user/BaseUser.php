<?php

namespace getways\users\logic\user;

use Carbon\Carbon;
use Exception;
use getways\users\models\Branch;
use getways\users\models\PaymentMethod;
use getways\users\repositories\UserRepository;
use getways\users\resources\BranchResource;
use getways\users\resources\UserTransactionsResource;
use getways\users\resources\WalletMovementResource;
use getways\users\resources\WalletResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BaseUser
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    protected function uploadUserImages(&$data)
    {
        if (array_key_exists('national_id_photo', $data)) {
            $image = Arr::pull($data, 'national_id_photo');
            $data['national_id_photo'] = upload($image, 'user_images');
        }
    }
    
    public function activateUser($UserId)
    {
        try {
            $user = $this->userRepository->get_user_data($UserId);
            if(!$user) {
                throw new Exception(__('User not found'), 404);
            }
            $status = $user->status == 0 ? 1 : 0;
            $this->userRepository->updateUserStatus($user, $status);
            $message = $user->status ? 'This user will be using the application.' : 'Use of the application is not possible for this user.';
            return sendResponse(true, __($message), []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }
    }

    public function block_user(array $data)
    {
        try {
            $UserId = $data['id'];
            $user = $this->userRepository->get_user_data($UserId);
            $block = $user->block == '0' ? '1' : '0';
            $user->update([
                'block' => $block,
                'block_reason' => $data['reason'],
                'action_by'=> Auth::guard('admin')->id(),
                'action_at'=>Carbon::now()
            ]);
            $message = $user->block ? 'This user is blocked.' : 'This user is unblocked.';
            return sendResponse(true, __($message), []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }
    }

    public function chargeWallet($data): \Illuminate\Http\JsonResponse
    {
        try {
            $request = $data['request'];
            $payment_method_type = PaymentMethod::find($request->payment_method_id)?->paymentMethodGroup?->type;
            if ($payment_method_type){
                if ($payment_method_type == 'online_visa'){  /* charge online with visa or mastercard*/
                    return $this->userRepository->via_visa_mastercard($data);
                }
                elseif ( $payment_method_type == 'online_installment'){ /*charge with online installment*/
                    return $this->userRepository->via_installment($data);
                }
                else{
                    return $this->userRepository->via_local($data);
                }
            }
            return sendResponse(false, __('The payment method does not exist.'), null, null, 500);

        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('wallet transaction exception'), null, $em, 500);
        }

    }

    public function Transactions($request,$user)
    {
        try {
            $criteria = $this->userRepository->userTransaction($request,$user);
        if ($criteria['count'] > 0){
            return sendListResponse(true, __('Your transactions.'), $criteria['count'],
                $criteria['total'], UserTransactionsResource::collection($criteria['list']));
        }
        return sendResponse(false, __('You do not have a transactions Yet.'), null, null, 500);

        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('wallet transaction exception'), null, $em, 500);
        }
    }
    public function branches($request)
    {
        try {
            $countryId = config('app.country_id');
            $branches = Branch::where('country_id',$countryId)->where('status',1)->get();
            return sendResponse(true, __('Branches'), BranchResource::collection($branches), null, 200);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('wallet transaction exception'), null, $em, 500);
        }
    }
    public function userWallet(array $data)
    {
        try {
            return sendResponse(true, __('User wallet'), new WalletResource($data['user']), null, 200);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('wallet transaction exception'), null, $em, 500);
        }
    }
    public function userWalletAction(array $data)
    {
        try {
            $criteria = $this->userRepository->userWalletAction($data['request'],$data['user']);
            return sendListResponse(true, __('User wallet actions'), $criteria['count'],
                $criteria['total'], WalletMovementResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('wallet transaction exception'), null, $em, 500);
        }
    }
    public function Currency(array $data)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => __('User currency'),
                'currency'=>__($data['user']->country->Currency_code)
            ]);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('wallet transaction exception'), null, $em, 500);
        }
    }
}
