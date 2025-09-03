<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $session = session();

        $token = null;

        // 1️⃣ Check Authorization header
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        // 2️⃣ Fallback: Check session storage
        if (!$token && $session->has('token')) {
            $token = $session->get('token');
        }

        // 3️⃣ Still no token? Block request
        if (!$token) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Token required'])
                ->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            // Attach user data so controllers can use it
            $request->user = $decoded->data;
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Invalid token: ' . $e->getMessage()])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }
}
