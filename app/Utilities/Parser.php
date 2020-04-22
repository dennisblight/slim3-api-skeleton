<?php
namespace App\Utilities;

class Parser
{
    public static function parse($payload, $code = 0, $message = 'OK', $errors = [])
    {
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $payload,
        ];

        if(!empty($errors)) $data['errors'] = $errors;

        return $data;
    }

    public function parseSuccess()
    {
        return ['code' => 0, 'message' => 'OK'];
    }
}