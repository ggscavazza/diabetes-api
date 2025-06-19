<?php

namespace Tests\Unit;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Tests\Support\CIUnitTestCaseBase;

class UserModelTest extends CIUnitTestCaseBase
{
    protected UserModel $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new UserModel();
        $this->model->truncate(); // limpa a tabela antes do teste
    }

    public function test_can_insert_user()
    {
        $id = $this->model->insert([
            'name' => 'João da Silva',
            'email' => 'joao@example.com',
            'password' => '123456'
        ]);

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);

        $user = $this->model->find($id);

        $this->assertEquals('João da Silva', $user['name']);
        $this->assertEquals('joao@example.com', $user['email']);
        $this->assertTrue(password_verify('123456', $user['password']));
    }

    public function test_email_must_be_unique()
    {
        $this->model->insert([
            'name' => 'Usuário 1',
            'email' => 'duplicado@example.com',
            'password' => 'abc'
        ]);

        $this->expectException(DatabaseException::class);

        $this->model->insert([
            'name' => 'Usuário 2',
            'email' => 'duplicado@example.com',
            'password' => 'xyz'
        ]);
    }

    public function test_can_find_by_email()
    {
        $this->model->insert([
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'password' => 'senha'
        ]);

        $user = $this->model->where('email', 'maria@example.com')->first();

        $this->assertNotNull($user);
        $this->assertEquals('Maria', $user['name']);
        $this->assertTrue(password_verify('senha', $user['password']));
    }
}
