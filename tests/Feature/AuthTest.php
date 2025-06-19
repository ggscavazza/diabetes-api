<?php
  namespace Tests\Feature;

  use Tests\Support\CIFeatureTestCase;

  class AuthTest extends CIFeatureTestCase
  {
      protected $basePath = '/api';

      public function test_user_can_register()
      {
          $response = $this->withBodyFormat('json')->post("{$this->basePath}/register", [
              'name' => 'Novo Usuário',
              'email' => 'novo@example.com',
              'password' => '123456',
          ]);

          $response->assertStatus(201);
          $response->assertJSONFragment(['message' => 'Usuário registrado com sucesso.']);
      }
  }
