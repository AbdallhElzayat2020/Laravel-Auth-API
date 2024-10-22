<?php


namespace App\Http\Controllers\Api;


trait ApiResponseTrait
{



    public function apiResponse($data = null, $message = null, $status = null)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ]);
    }
}