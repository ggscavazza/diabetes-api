<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createJWT($user)
{
  $key = getenv('JWT_SECRET');

  if (!$key) {
    throw new Exception('Chave JWT não encontrada.');
  }

  $payload = [
    'iss' => 'diabetes-api',
    'sub' => $user['id'],
    'iat' => time(),
    'exp' => time() + (60 * 60 * 24) // 24h
  ];

  return JWT::encode($payload, $key, 'HS256');
}

function decodeJWT($token)
{
  return JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
}
