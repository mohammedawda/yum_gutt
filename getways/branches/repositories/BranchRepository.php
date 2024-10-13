<?php

namespace getways\settings\repositories;

use getways\settings\models\Branch;
use getways\settings\models\Setting;
use Illuminate\Support\Facades\Auth;

class BranchRepository
{
    public function storeBranch(mixed $store_data)
    {
        $store_data['country_id'] = Auth::guard('admin')->user()->country_id;
        $branch = Branch::create($store_data);
        $data = $this->branchDetails($branch->id);
        return $data['data'];
    }

    public function index($request)
    {
        $rows = getSkipTake($request);
        $admin_country_id = Auth::guard('admin')->user()->country_id;
        $branch = Branch::where('country_id',$admin_country_id);
        $branch = $branch
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->type, function($query) {
                $query->orderByDesc('type');
            })
            ->when($request->has('city_id'), function($query) use ($request){
                $query->where('city_id',$request->city_id);
            })
        ;
        $criteria['total'] = $branch->count();
        $criteria['list']  = $branch->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function branchDetails($id)
    {
        $branch = Branch::find($id);
        if ($branch){
            return [
              'status'=>true,
              'data'=>$branch
            ];
        }
        return [
            'status'=>false,
            'message'=>__('No data found.')
        ];
    }

    public function updateBranch(mixed $update_data, mixed $branch)
    {
        return $branch->update($update_data);
    }

    public function branchChangeStatus(mixed $branch)
    {
        $newStatus = $branch->status ? '0' : '1';
        return $branch->update(['status' => $newStatus]);
    }


}
