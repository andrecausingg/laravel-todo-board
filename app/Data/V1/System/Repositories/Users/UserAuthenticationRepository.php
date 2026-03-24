<?php

namespace App\Data\V1\System\Repositories\Users;

use App\Data\V1\System\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\V1\System\Users\UsersAccountModel;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthenticationRepository extends Controller
{
    /**
     * Summary of logoutRepository
     * @param mixed $payload
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logoutRepository()
    {
        $helper = app()->make(Helper::class);

        try {
            return $helper->httpOkHelper([
                'title_message' => 'Success',
                'message' => 'Successfully logged out.',
            ])->cookie(
                'tokenCookie',
                null,
                -1,
                '/',
                config('env.env_session_domain'),
                config('env.env_app') != 'local',
                true,
                false,
                null
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
            ]);
        }
    }

    /**
     * Summary of loginRepository
     * @param mixed $payload
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function loginRepository($payload = [])
    {
        $helper = app()->make(Helper::class);

        $http_response_data = [
            'payload' => $payload,
        ];

        try {
            $model_result = UsersAccountModel::where('email', $payload['email'])->first();
            if (!$model_result) {
                return $helper->httpOkHelper([
                    'title_message' => 'Not found.',
                    'message' => 'Credential not found.',
                ]);
            }

            $new_token = JWTAuth::claims(['exp' => Carbon::now()->addMonths(3)->timestamp,])->fromUser($model_result);

            return $helper
                ->httpOkHelper([
                    'title_message' => 'Success.',
                    'message' => 'Successfully login.',
                ])
                ->cookie(
                    'tokenCookie', // Cookie name
                    $new_token,    // Cookie value
                    (int) Carbon::now()->diffInMinutes(Carbon::now()->addMonths(3)),
                    null,           // Path
                    config('env.env_session_domain'),   // Domain
                    config('env.env_app') != 'local' ? true : false, // Secure flag
                    true,          // HttpOnly
                    false,         // Raw
                    null // SameSite
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
     * Summary of registerRepository
     * @param mixed $payload
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function registerRepository($payload = [])
    {
        $helper = app()->make(Helper::class);

        $http_response_data = [
            'payload' => $payload,
        ];

        try {
            $model_result = UsersAccountModel::create($payload);

            return $helper->httpOkHelper([
                'title_message' => 'Success.',
                'message' => 'Success register account.',
                'result' => $model_result,
            ]);
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
