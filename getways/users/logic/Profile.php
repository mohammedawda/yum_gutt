<?php

namespace getways\users\logic;

use Exception;
use getways\users\models\Question;
use getways\users\models\User;
use getways\users\repositories\AuthRepository;
use getways\users\resources\UserProfileResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Profile
{
    public function __construct(private AuthRepository $userRepository)
    {
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        $response_data =  new UserProfileResource($user) ;
        return sendResponse(true, trans('profile data'), $response_data);
    }

    public function update_profile($request)
    {
        $validate = $request->validated();
        try {
            DB::beginTransaction();
            if($request->nationalId_photo){
                $image = Arr::pull($validate, 'nationalId_photo');
                if (File::isFile($image)) {
                    $image_path = Upload($image, 'images');
                    $validate['nationalId_photo'] = $image_path;
                }
            }else{
                unset($validate['nationalId_photo']);
            }
            $result = $this->userRepository->updateUserProfile($validate);

            DB::commit();
            $response_data =  new UserProfileResource($result);

            return sendResponse(true, trans('profile data updated'), $response_data);
        } catch (ModelNotFoundException $exception) {
            return sendResponse(false,__('Update profile exception'), [],$exception, 404);
        }
    }

    public function update_password($request)
    {
        $validate = $request->validated();
        try {
            DB::beginTransaction();
            $result = $this->userRepository->updateUserPassword($validate);
            DB::commit();
            if ($result['status']) {
                return sendResponse(true, trans('change password'), new UserProfileResource($result['data']));
            }

            return sendResponse($result['status'],$result['message'], [],null, 404);

        } catch (ModelNotFoundException $exception) {
            return sendResponse(false,__('Update profile exception'), [],$exception, 404);
        }
    }

}
