<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function errorResponse($errors = [], $code = 400, $message = 'Error')
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    public function validateAjax(Request $request)
    {
        $ajax = $request->ajax() || request()->ajax() || $request->isJson() || $request->wantsJson();
        if (!$ajax) {
            $ajax = isset($request->a) ? $request->a : false;
        }

        return $ajax;
    }

    public function successResponse($message, $data = [])
    {
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $data
        ], 200);
    }
}
