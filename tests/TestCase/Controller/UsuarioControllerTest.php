<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class UsuarioControllerTest extends TestCase
{
    use IntegrationTestTrait;

    private Table $usuariosTable;

    protected $fixtures = [
        'app.Usuario',
        'app.Tarefa',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->usuariosTable = TableRegistry::getTableLocator()->get('Usuario');

    }

    public function testFixtureLoading()
    {
        $usuarios = $this->getTableLocator()->get('Usuario')->find()->all();
        debug($usuarios->toArray());
        $this->assertNotEmpty($usuarios);
    }

    public function testIndex(): void
    {
        $this->sessionLogin();
        $this->get('/usuario');

        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $this->sessionLogin();
        $data = [
            'nome' => 'Novo Usuário',
            'email' => 'novo@teste.com',
            'senha' => 'senha123',
            'cpf' => '12345678903',
            'telefone' => '11987654321',
            'data_nascimento' => '2000-01-01',
        ];
        $this->post('/usuario/add', $data);

        $usuario = $this->usuariosTable->find()->where(['email' => 'novo@teste.com'])->first();
        $this->assertNotEmpty($usuario);
        $this->assertEquals('Novo Usuário', $usuario->nome);
        $this->assertEquals('novo@teste.com', $usuario->email);
        $this->assertEquals('12345678903', $usuario->cpf);
        $this->assertEquals('11987654321', $usuario->telefone);
        $this->assertEquals('2000-01-01', $usuario->data_nascimento->format('Y-m-d'));
    }

    public function testEdit(): void
    {
        $this->sessionLogin();
        $data = [
            'nome' => 'Usuário Atualizado',
            'email' => 'atualizado@teste.com',
        ];
        $this->put('/usuario/edit/1', $data);

        $usuario = $this->usuariosTable->find()->where(['id' => '1'])->first();
        $this->assertNotEmpty($usuario);
        $this->assertEquals('Usuário Atualizado', $usuario->nome);
        $this->assertEquals('atualizado@teste.com', $usuario->email);
    }

    public function testDelete(): void
    {
        $this->sessionLogin();
        $this->delete('/usuario/delete/1');

        $usuario = $this->usuariosTable->find()->where(['id' => '1'])->first();
        $this->assertEmpty($usuario);
    }

    public function testLoginSucesso(): void
    {
        $this->post('/usuario/login', [
            'email' => 'login@teste.com',
            'senha' => 'senha123',
        ]);

        $usuario = $this->usuariosTable->find()->where(['email' => 'login@teste.com'])->first();
        $this->assertResponseSuccess();
        $this->assertSession($usuario->id, 'Auth.User.id');
        $this->assertRedirect('/');
    }

    public function testLoginComErro(): void
    {
        $this->post('/usuario/login', [
            'email' => 'login@teste.com',
            'senha' => 'senhaErrada',
        ]);

        $this->assertResponseOk();
        $this->assertResponseContains('Seu email ou senha estão incorretos.');
    }

    public function testSenhaHash(): void
    {
        $data = [
            'nome' => 'Novo Senha',
            'email' => 'novo@Senha.com',
            'senha' => 'senha123',
            'cpf' => '12345678902',
            'telefone' => '11987654321',
            'data_nascimento' => '2000-01-01',
        ];
        $this->post('/usuario/add', $data);

        $usuario = $this->usuariosTable->find()->where(['email' => 'novo@Senha.com'])->first();
        $this->assertNotEquals('senha123', $usuario->senha);
        $this->assertTrue(password_verify('senha123', $usuario->senha));
    }

    private function sessionLogin(): void
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'nome' => 'Teste',
                    'email' => 'teste@teste.com',
                ],
            ],
        ]);
    }
}
