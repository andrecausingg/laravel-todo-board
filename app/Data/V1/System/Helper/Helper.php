<?php

namespace App\Data\V1\System\Helper;

use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;


class Helper
{
    /**
     * Summary of concatMessageErrorServerHelper
     * @return string
     */
    public function concatMessageErrorServerHelper()
    {
        return ' Please contact the admin to fix this. Send a screenshot, along with what you input and the error, so the problem can be identified more quickly.';
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
