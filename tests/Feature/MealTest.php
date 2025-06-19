<?php

namespace Tests\Feature;

use Tests\Support\CIFeatureTestCase;

class MealTest extends CIFeatureTestCase
{
    protected $basePath = '/api/meals';
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Exemplo: se suas rotas usam JWT, gere um token de teste aqui
        $this->token = $this->getAuthToken();
    }

    protected function getAuthToken(): string
    {
        $response = $this->withBodyFormat('json')->post('/api/login', [
            'email' => 'teste@example.com',
            'password' => '123456',
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['token'] ?? '';
    }

    public function test_create_meal()
    {
        $response = $this
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->withBodyFormat('json')
            ->post($this->basePath, [
                'description' => 'Café da manhã',
                'carbs' => 45,
                'eaten_at' => '2025-06-19 07:30:00'
            ]);

        $response->assertStatus(201);
        $response->assertJSONFragment(['message' => 'Refeição registrada com sucesso.']);
    }

    public function test_get_meals_by_date()
    {
        $response = $this
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->get($this->basePath . '?date=2025-06-19');

        $response->assertStatus(200);
        $response->assertJSON(fn($json) =>
            $json->has('meals')->etc()
        );
    }

    public function test_update_meal()
    {
        $create = $this
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->withBodyFormat('json')
            ->post($this->basePath, [
                'description' => 'Almoço',
                'carbs' => 80,
                'eaten_at' => '2025-06-19 12:00:00'
            ]);

        $meal = json_decode($create->getBody(), true)['data'] ?? null;

        $response = $this
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->withBodyFormat('json')
            ->put("{$this->basePath}/{$meal['id']}", [
                'description' => 'Almoço editado',
                'carbs' => 90,
            ]);

        $response->assertStatus(200);
        $response->assertJSONFragment(['message' => 'Refeição atualizada com sucesso.']);
    }

    public function test_delete_meal()
    {
        $create = $this
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->withBodyFormat('json')
            ->post($this->basePath, [
                'description' => 'Lanche da tarde',
                'carbs' => 20,
                'eaten_at' => '2025-06-19 15:30:00'
            ]);

        $meal = json_decode($create->getBody(), true)['data'] ?? null;

        $response = $this
            ->withHeaders(['Authorization' => "Bearer {$this->token}"])
            ->delete("{$this->basePath}/{$meal['id']}");

        $response->assertStatus(200);
        $response->assertJSONFragment(['message' => 'Refeição excluída com sucesso.']);
    }
}
