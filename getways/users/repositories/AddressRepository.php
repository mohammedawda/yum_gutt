<?php

namespace getways\users\repositories;

use Exception;
use getways\users\models\UserAddress;
use Illuminate\Support\Facades\Auth;

class AddressRepository
{
    public string $model = UserAddress::class;
    public function index($request): array
    {
        $countryId = config('app.country_id');
        $admins = $this->model::where('country_id',$countryId)->where('user_id',Auth::guard('user')->id())

            ->when($request->name, function($query) use($request){
                $query->where('name', $request->name);
            })
        ;
        return getTakedPreparedCollection($admins,$request);
    }

    public function Store(mixed $validate)
    {
        $validate['user_id'] = Auth::guard('user')->id();
        $validate['country_id'] = config('app.country_id');
        return $this->model::create($validate);
    }

    /**
     * @throws Exception
     */
    public function getRecord($id)
    {
        $record = $this->model::find($id);
        if ($record){
            if ($record->user_id != Auth::guard('user')->id()) {
                throw new Exception(__('This address is not accessible.'), 403);
            }
            return $record;
        }
        throw new Exception(__('We did not find this data.'), 403);
    }

    /**
     * @throws Exception
     */
    public function Update(mixed $validate, $id)
    {
        $this->getRecord($id)->update($validate);
        return $this->getRecord($id);
    }

    /**
     * @throws Exception
     */
    public function Destroy($id): void
    {
        $this->getRecord($id)->delete();
    }
}
