<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsuarioTable Test Case
 */
class UsuarioTableTest extends TestCase
{

    protected $Usuario;

    protected $fixtures = [
        'app.Usuario',
        'app.Tarefa',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->Usuario = $this->getTableLocator()->get('Usuario');
    }

    public function testValidacaoNomeVazio(): void
    {
        $usuario = $this->Usuario->newEntity(['nome' => '']);
        $this->assertArrayHasKey('nome', $usuario->getErrors(), 'O nome não pode ser vazio.');
    }

    public function testValidacaoEmailInvalido(): void
    {
        $usuario = $this->Usuario->newEntity(['email' => 'email-invalido']);
        $this->assertArrayHasKey('email', $usuario->getErrors(), 'Email inválido.');
    }

    public function testValidacaoDataNascimentoFuturo(): void
    {
        $usuario = $this->Usuario->newEntity(['data_nascimento' => date('Y-m-d', strtotime('+1 day'))]);
        $this->assertArrayHasKey('data_nascimento', $usuario->getErrors(), 'A data de nascimento não pode ser no futuro.');
    }

    public function testCPFUnico(): void
    {
        $usuario1 = $this->Usuario->find()->where(['cpf' => '12345678909'])->first();
        $this->assertNotEmpty($usuario1);

        $usuario2 = $this->Usuario->newEntity(['cpf' => '12345678909']);
        $this->Usuario->save($usuario2);

        $this->assertArrayHasKey('cpf', $usuario2->getErrors(), 'CPF já cadastrado.');
    }

    public function testTelefoneFormato(): void
    {
        $usuario = $this->Usuario->newEntity(['telefone' => '']);
        $this->assertArrayHasKey('telefone', $usuario->getErrors(), 'O telefone é obrigatório');
    }
}
