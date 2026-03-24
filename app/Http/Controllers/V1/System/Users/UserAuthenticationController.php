<?php

namespace App\Http\Controllers\V1\System\Users;

use App\Data\V1\System\Helper\Helper;
use App\Data\V1\System\Repositories\Users\UserAuthenticationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAuthenticationController extends Controller
{
    /**
     * Login account
     * 
     * Summary of loginController
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function loginController(Request $request)
    {
        $helper = app()->make(Helper::class);
        $repo_user_auth = app()->make(UserAuthenticationRepository::class);

        $http_response_data['payload'] = $request->all() ?? null;

        try {
            $validator = Validator::make(
                $request->all(),
                (new LoginRequest())
                    ->rules()
            );
            if ($validator->fails()) {
                return $helper->httpUnprocessableEntityHelper([
                    'errors' => $validator->errors(),
                ]);
            }

            $validated_data = $validator->validated();

            return $repo_user_auth->loginRepository(
                $validated_data,
            );
        } catch (\Exception $e) {
            $exception_error = [
                'error_line' => $e->getLine(),
                'error_message' => $e->getMessage(),
            ];

            return $helper->httpInternalServerErrorHelper([
                'class_name' => __CLASS__,
                'function_name' => __FUNCTION__,
                'error_list' => $exception_error,
                'payload' => $http_response_data,
            ]);
        }
    }

    /**
     * Register account
     * 
     * Summary of registerController
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function registerController(Request $request)
    {
        $helper = app()->make(Helper::class);
        $repo_user_auth = app()->make(UserAuthenticationRepository::class);

        $http_response_data['payload'] = $request->all() ?? null;

        try {
            $validator = Validator::make(
                $request->all(),
                (new RegisterRequest())
                    ->rules()
            );
            if ($validator->fails()) {
                return $helper->httpUnprocessableEntityHelper([
                    'errors' => $validator->errors(),
                ]);
            }

            $validated_data = $validator->validated();

            return $repo_user_auth->registerRepository(
                $validated_data,
            );
        } catch (\Exception $e) {
            $exception_error = [
                'error_line' => $e->getLine(),
                'error_message' => $e->getMessage(),
            ];

            return $helper->httpInternalServerErrorHelper([
                'class_name' => __CLASS__,
                'function_name' => __FUNCTION__,
                'error_list' => $exception_error,
                'payload' => $http_response_data,
            ]);
        }
    }
}
