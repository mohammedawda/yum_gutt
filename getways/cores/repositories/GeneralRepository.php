<?php

namespace getways\cores\repositories;

use App\Support\Factory\Payment\ChargeWalletPayment;
use getways\cores\models\City;
use getways\cores\models\Country;
use getways\cores\models\PaymentMethodGroup;
use getways\users\models\Question;
use getways\users\models\User;
use getways\users\models\WalletTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class GeneralRepository
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

    public function payment_method($request)
    {
        $countryId = config('app.country_id');

//        $paymentMethodGroups = PaymentMethodGroup::with(['payment_methods' => function($query) use ($countryId) {
//            $query->where('country_id', $countryId);
//        }])->get();

        return PaymentMethodGroup::whereHas('payment_methods', function($query) use ($countryId) {
            $query->where('country_id', $countryId);
        })->with(['payment_methods' => function($query) use ($countryId) {
            $query->where('country_id', $countryId);
        }])->get();
    }


    public function cities($request)
    {
        $rows = getSkipTake($request);
        $field_name = app()->getLocale() == 'ar' ? "name_ar" : "name_en";
        $cities = City::where('status',1)->orderBy($field_name, 'asc');
        $cities = $cities
            ->when($request->has('search'), function($query) use ($field_name,$request){
                $query->where($field_name, 'like', '%' . $request->search . '%');
            })
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->country_id, function($query) use($request){
                $query->where('country_id', $request->country_id);
            })
        ;
        $criteria['total'] = $cities->count();
        $criteria['list']  = $cities->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function countries($request)
    {
        $rows = getSkipTake($request);
        $countries = Country::where('status',1);
        $countries = $countries
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
        ;
        $criteria['total'] = $countries->count();
        $criteria['list']  = $countries->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

}
