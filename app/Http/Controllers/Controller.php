<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateResponse(string $status = '', 
        string $message = '', 
        int $code = 200,
        array $data = null,
        array $errors = null,
    )
    {
        $response = [
            'status' => $status,
            'message' => $message
        ];

        if($data) {
            $response['data'] = $data;
        }

        if($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
