<?php
namespace Tests\Feature;

use Tests\Support\CIFeatureTestCase;

class GlucoseTest extends CIFeatureTestCase
{
    protected $basePath = '/api';

    public function test_can_register_glucose_reading()
    {
        $response = $this->withBodyFormat('json')->post("{$this->basePath}/glucose", [
            'value' => 110,
            'measured_at' => '2025-06-19 08:00:00',
        ]);

        $response->assertStatus(201);
        $response->assertJSONFragment(['message' => 'Leitura registrada com sucesso.']);
    }
}
