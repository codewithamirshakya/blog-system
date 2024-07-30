<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function successResponse($message, $data = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data],$status);
    }

    public function failureResponse($message, $data = null, $status = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data],$status);
    }
}
