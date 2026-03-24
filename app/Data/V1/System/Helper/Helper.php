<?php

namespace App\Data\V1\System\Helper;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Encryption\DecryptException;


class Helper
{
    /**
     * Summary of isEncryptedHelper
     * @param mixed $value
     * @return bool
     * 
     * Check if encrypted data
     */
    public function isEncryptedHelper($value)
    {
        try {
            Crypt::decrypt($value);
            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }

    /**
     * Summary of modifiedKeyValue
     * @param mixed $keys
     * @param mixed $payload
     * @return void
     */
    public function modifiedKeyValue($keys = [], &$payload = [])
    {
        if (empty($keys) || empty($payload)) return;

        foreach ($keys as $action => $field_names) {
            // Encryption
            if ($action === 'enc' && is_array($field_names)) {
                foreach ($field_names as $field_name) {
                    if (isset($payload[$field_name])) {
                        $payload[$field_name] = Crypt::encrypt($payload[$field_name]);
                    }
                }
            }
        }
    }


    /**
     * Summary of injectAuthUserToPayload
     * @return void
     */
    public function injectAuthUserToPayload(&$payload = [])
    {
        $auth_user = request()->input('auth_user');

        $payload['created_by_number_user_id'] = $auth_user->id ?? null;
        $payload['created_by_uuid_user_id'] =  $auth_user->uuid_user_id ?? null;
    }

    /**
     * Summary of concatMessageErrorServerHelper
     * @return string
     */
    public function concatMessageErrorServerHelper()
    {
        return ' Please contact the admin to fix this. Send a screenshot, along with what you input and the error, so the problem can be identified more quickly.';
    }

    /**
     * Summary of httpNotFoundHelper
     * @param array $append_response
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpNotFoundHelper(array $append_response)
    {
        $response_data = [
            'title_message' => 'Not Found',
            'message' => 'Oops! We couldn`t find what you were looking for.',
            'date_time' => Carbon::now()->format('F j, Y g:i:s a'),
        ];

        $response_data = array_merge($response_data, $append_response);

        return response()->json($response_data, Response::HTTP_NOT_FOUND);
    }


    /**
     * Response Unprocessable entity
     * 
     * Summary of httpUnprocessableEntityHelper
     * @param array $append_response
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpUnprocessableEntityHelper(array $append_response)
    {
        $response_data = [
            'title_message' => 'Invalid Input',
            'message' => 'Some input did not pass validation. Please check and try again.',
            'date_time' => Carbon::now()->format('F j, Y g:i:s a'),
        ];

        $response_data = array_merge($response_data, $append_response);

        return response()->json($response_data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * Response Ok
     * 
     * Summary of httpOkHelper
     * @param array $append_response
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpOkHelper(array $append_response)
    {
        $response_data = [
            'title_message' => 'Success',
            'message' => 'Success.',
            'date_time' => Carbon::now()->format('F j, Y g:i:s a'),
        ];

        $response_data = array_merge($response_data, $append_response);

        return response()->json($response_data, Response::HTTP_OK);
    }


    /**
     * Response Internal Server error
     * 
     * Summary of httpInternalServerErrorHelper
     * @param array $append_response
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function httpInternalServerErrorHelper(array $append_response)
    {
        $response_data = [
            'title_message' => 'Internal Server error',
            'message' => 'An unexpected error occurred.' . $this->concatMessageErrorServerHelper(),
            'contact' => [
                'admin@admin.com',
            ],
            'date_time' => Carbon::now()->format('F j, Y g:i:s a'),
        ];

        $response_data = array_merge($response_data, $append_response);

        return response()->json($response_data, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
