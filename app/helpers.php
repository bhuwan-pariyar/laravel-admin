<?php

use Illuminate\Support\Facades\Request;

function active_menu($path, $active = 'active')
{
    return Request::is($path) ? $active : '';
}

function success($message = "Success", $alert_type = "success", $data = [], $status = 200)
{
    return response()->json([
        'status'  => true,
        'message' => $message,
        'alert-type' => $alert_type,
        'data'    => $data,
    ], $status);
}

function failure($message = "Failure", $alert_type = "error", $errors = [], $status = 400)
{
    return response()->json([
        'status'  => false,
        'message' => $message,
        'alert-type' => $alert_type,
        'errors'  => $errors,
    ], $status);
}
