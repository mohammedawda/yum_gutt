<?php

namespace getways\cores\repositories;

use getways\cores\models\City;
use getways\cores\models\Country;
use getways\cores\models\PaymentMethodGroup;
use getways\users\models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class CityRepository
{
    public $model = City::class;
    public function index($request)
    {
        $rows = getSkipTake($request);
        $countryId = config('app.country_id');
        $cities = $this->model::where('status',1)->where('country_id',$countryId)
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->country_id, function($query) use($request){
                $query->where('country_id', $request->country_id);
            })
            ->when($request->has('sort_name_ar'), function($query) use($request){
                $sort = $request->sort_name_ar ? 'asc' : "desc";
                $query->orderBy('name_ar', $sort);
            })
            ->when($request->has('sort_name_en'), function($query) use($request){
                $sort = $request->sort_name_en ? 'asc' : "desc";
                $query->orderBy('name_en', $sort);
            })
            ->when($request->has('search_name_ar'), function($query) use ($request){
                $query->where('name_ar', 'like', '%' . $request->search_name_ar . '%');
            })
            ->when($request->has('search_name_en'), function($query) use ($request){
                $query->where('name_en', 'like', '%' . $request->search_name_en . '%');
            })
            ->when($request->has('delivery_cost'), function($query) use($request){
                $query->where('delivery_cost', $request->delivery_cost);
            })
        ;
        $criteria['total'] = $cities->count();
        $criteria['list']  = $cities->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function Store(mixed $validate)
    {
        return $this->model::create($validate);
    }

    public function getRecord($id)
    {
        $record = $this->model::find($id);
        if ($record){
            return [
                'status'=>true,
                'record'=>$record
            ];
        }
        return [
            'status'=>false,
        ];
    }
    public function Update(mixed $validate,$id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $record['record']->update($validate);
        }
    }
    public function changeStatus($id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $status = $record['record'] ? '0' : '1';
            $record['record']->update([
                'status'=>$status
            ]);
        }
    }
    public function Destroy( $id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $record['record']->delete();
        }
    }

}
