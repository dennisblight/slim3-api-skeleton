<?php

use Firebase\JWT\JWT;

return function ($container) {
    
    return function ($payload = []) {
        $setting = load_setting('jwt');
        $payload = array_merge(
            ['jti' => JWT::urlsafeB64Encode(random_bytes(32))],
            $payload, [
                'iat' => time(),
                'exp' => strtotime($setting['duration']),
            ]
        );
        return JWT::encode($payload, $setting['secret']['private'], $setting['algorithm'], 'public');
    };
};