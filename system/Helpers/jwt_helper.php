<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('getJWTForUser')) {
    function getJWTForUser($userId, $email,$role)
    {
        $key = getenv('JWT_SECRET'); // store in .env
        $expTime = match ($role) {
            'admin' => time() + (60 * 60 * 24),        // 30 min
            'vendor' => time() + (60 * 60 *24),       // 2 hours
            'user' => time() + (60 * 60 * 24),   // 24 hours
            default => time() + (60 * 60),        // fallback: 1 hour
        };
        $payload = [
            'iss' => 'http://localhost/ciapp', // Issuer
            'aud' => 'http://localhost/ciapp', // Audience
            'iat' => time(),                   // Issued at
            'exp' => $expTime,            // Expiration (1 hour)
            'data' => [
                'id' => $userId,
                'email' => $email,
                'role'=>$role
            ]
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('decodeJWT')) {
    function decodeJWT($jwt)
    {
        $key = getenv('JWT_SECRET');
        return JWT::decode($jwt, new Key($key, 'HS256'));
    }
}
