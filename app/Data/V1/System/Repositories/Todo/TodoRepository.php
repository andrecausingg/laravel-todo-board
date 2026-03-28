<?php

namespace App\Data\V1\System\Repositories\Todo;

use App\Data\V1\System\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\V1\System\Todo\TodoModel;

class TodoRepository extends Controller
{
    public function indexTodoRepository()
    {
        $helper = app()->make(Helper::class);
        $final_data = [];

        $arr_keys_encrypt = [
            'enc' => ['uuid_todo_id']
        ];

        try {
            $auth_user = request()->input('auth_user');
            $uuid_user_id = $auth_user->uuid_user_id;

            $todos = TodoModel::where('created_by_uuid_user_id', $uuid_user_id)->get();

            if ($todos->isNotEmpty()) {
                foreach ($todos as $todo) {
                    $payload = $todo->toArray();
                    $helper->modifiedKeyValue($arr_keys_encrypt, $payload);
                    $final_data[] = $payload;
                }
            }

            return $helper->httpOkHelper([
                'title_message' => 'Success',
                'message' => 'Successfully retrieved todos.',
                'data' => $final_data,
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
            ]);
        }
    }

    public function storeTodoRepository($payload = [])
    {
        $helper = app()->make(Helper::class);

        $http_response_data = [
            'payload' => $payload,
        ];

        try {
            $helper->injectAuthUserToPayload($payload);

            $model_result = TodoModel::create($payload);

            return $helper->httpOkHelper([
                'title_message' => 'Success',
                'message' => 'Success create todo.',
                'data' => $model_result,
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

    public function updateTodoRepository($payload = [], $decrypted_id = null, $model_result = null)
    {
        $helper = app()->make(Helper::class);

        $http_response_data = [
            'payload' => $payload,
            'decrypted_id' => $decrypted_id,
        ];

        try {
            $model_result->update($payload);

            return $helper->httpOkHelper([
                'title_message' => 'Success',
                'message' => 'Success update todo.',
                'data' => $model_result,
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

    public function destroyTodoRepository($payload = [], $decrypted_id = null, $model_result = null)
    {
        $helper = app()->make(Helper::class);

        $http_response_data = [
            'payload' => $payload,
            'decrypted_id' => $decrypted_id,
        ];

        try {
            $old_data = $model_result->toArray();
            $model_result->delete();

            return $helper->httpOkHelper([
                'title_message' => 'Success',
                'message' => 'Success delete todo.',
                'data' => $old_data,
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
