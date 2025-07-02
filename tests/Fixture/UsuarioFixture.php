<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsuarioFixture
 */
class UsuarioFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'usuario';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'senha' => 'Lorem ipsum dolor sit amet',
                'cpf' => '12345678909',
                'telefone' => 'Lorem ipsum d',
                'data_nascimento' => '2025-05-07',
                'created' => '2025-05-07 03:56:30',
            ],
            [
                'id' => 2,
                'nome' => 'Usuario Teste Login',
                'email' => 'login@teste.com',
                'senha' => '$2y$10$FNWFOtqqdljOBIA7P6cBn.TvxupsEB6IMmZrItREY70WfZM8hWZwO', //senha123
                'cpf' => '12345678901',
                'telefone' => '11987654321',
                'data_nascimento' => '2000-01-01',
                'created' => '2025-05-07 03:56:30',
            ],
        ];
        parent::init();
    }
}
