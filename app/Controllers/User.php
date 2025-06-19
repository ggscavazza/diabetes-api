<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    protected $format = 'json';

    public function profile()
    {
        $userId = service('request')->user_id ?? null;

        if (!$userId) {
            return $this->failUnauthorized('Usuário não autenticado.');
        }

        $model = new UserModel();
        $user = $model->find($userId);

        if (!$user) {
            return $this->failNotFound('Usuário não encontrado.');
        }

        unset($user['password']); // Nunca retornar a senha

        return $this->respond($user);
    }
}
