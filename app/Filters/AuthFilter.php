<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader) {
            return service('response')->setJSON(['error' => 'Token não informado'])->setStatusCode(401);
        }

        $token = explode(' ', $authHeader)[1] ?? null;

        if (!$token) {
            return service('response')->setJSON(['error' => 'Token inválido'])->setStatusCode(401);
        }

        try {
            $decoded = decodeJWT($token);
            $request->user_id = $decoded->sub;
            service('request')->user = $decoded;
        } catch (ExpiredException $e) {
            return service('response')->setJSON(['error' => 'Token expirado'])->setStatusCode(401);
        } catch (\Exception $e) {
            return service('response')->setJSON(['error' => 'Token inválido'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer aqui
    }
}
