<?php

namespace App\Http\Controllers\V1\System\Todo;

use App\Data\V1\System\Helper\Helper;
use App\Data\V1\System\Repositories\Todo\TodoRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\System\Todo\TodoRequest;
use App\Models\V1\System\Todo\TodoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Summary of storeTodoController
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function indexTodoController(Request $request)
    {
        $helper = app()->make(Helper::class);
        $repo_todo = app()->make(TodoRepository::class);

        $http_response_data['payload'] = $request->all() ?? null;

        try {
            return $repo_todo->indexTodoRepository();
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
     * Summary of storeTodoController
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function storeTodoController(Request $request)
    {
        $helper = app()->make(Helper::class);
        $repo_todo = app()->make(TodoRepository::class);

        $http_response_data['payload'] = $request->all() ?? null;

        try {
            $validator = Validator::make(
                $request->all(),
                (new TodoRequest())
                    ->rules()
            );
            if ($validator->fails()) {
                return $helper->httpUnprocessableEntityHelper([
                    'errors' => $validator->errors(),
                ]);
            }

            $validated_data = $validator->validated();

            return $repo_todo->storeTodoRepository(
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
     * Summary of storeTodoController
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function updateTodoController(Request $request, $id)
    {
        $helper = app()->make(Helper::class);
        $repo_todo = app()->make(TodoRepository::class);

        $http_response_data['payload'] = $request->all() ?? null;

        try {
            $validator = Validator::make(
                $request->all(),
                (new TodoRequest())
                    ->rules()
            );
            if ($validator->fails()) {
                return $helper->httpUnprocessableEntityHelper([
                    'errors' => $validator->errors(),
                ]);
            }

            if (!$helper->isEncryptedHelper($id)) {
                return $helper->httpUnprocessableEntityHelper([
                    'message' => 'The id is on invalid format.',
                ]);
            }

            $decrypted_id = Crypt::decrypt($id);
            $model_result = TodoModel::where('uuid_todo_id', $decrypted_id)->first();
            if (!$model_result) {
                return $helper->httpNotFoundHelper([
                    'title_message' => 'Not found.',
                    'message' => 'Id not found.',
                ]);
            }

            $validated_data = $validator->validated();

            return $repo_todo->updateTodoRepository(
                $validated_data,
                $decrypted_id,
                $model_result,
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
     * Summary of storeTodoController
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroyTodoController(Request $request, $id)
    {
        $helper = app()->make(Helper::class);
        $repo_todo = app()->make(TodoRepository::class);

        $http_response_data['payload'] = $request->all() ?? null;

        try {
            $validator = Validator::make(
                $request->all(),
                (new TodoRequest())
                    ->rules()
            );
            if ($validator->fails()) {
                return $helper->httpUnprocessableEntityHelper([
                    'errors' => $validator->errors(),
                ]);
            }

            if (!$helper->isEncryptedHelper($id)) {
                return $helper->httpUnprocessableEntityHelper([
                    'message' => 'The id is on invalid format.',
                ]);
            }

            $decrypted_id = Crypt::decrypt($id);
            $model_result = TodoModel::where('uuid_todo_id', $decrypted_id)->first();
            if (!$model_result) {
                return $helper->httpNotFoundHelper([
                    'title_message' => 'Not found.',
                    'message' => 'Id not found.',
                ]);
            }

            $validated_data = $validator->validated();

            return $repo_todo->destroyTodoRepository(
                $validated_data,
                $decrypted_id,
                $model_result,
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
