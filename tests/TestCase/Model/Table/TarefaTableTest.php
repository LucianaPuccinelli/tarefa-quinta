<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Tarefa;
use Cake\TestSuite\TestCase;

class TarefaTableTest extends TestCase
{
    protected $Tarefa;

    protected $fixtures = [
        'app.Tarefa',
        'app.Usuario',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->Tarefa = $this->getTableLocator()->get('Tarefa');
    }

    public function testValidacaoDescricaoVazia(): void
    {
        $tarefa = $this->Tarefa->newEntity(['descricao' => '']);
        $this->assertArrayHasKey('descricao', $tarefa->getErrors(), 'A descrição não pode ser vazia.');
    }

    public function testValidacaoDataPrevistaNoPassado(): void
    {
        $data = [
            'descricao' => 'Tarefa data prevista errada',
            'data_prevista' => date('Y-m-d', strtotime('-1 day')),
            'situacao' => Tarefa::SITUACAO_EM_ANDAMENTO,
            'usuario_id' => 1,
        ];

        $tarefa = $this->Tarefa->save($this->Tarefa->newEntity($data));
        $this->assertFalse($tarefa, 'A data prevista não pode ser antes da data de criação.');
    }

    public function testValidacaoDataEncerramentoNoPassado(): void
    {
        $data = [
            'descricao' => 'Tarefa data encerramento errada',
            'data_prevista' => date('Y-m-d', strtotime('+2 days')),
            'data_encerramento' => date('Y-m-d', strtotime('-1 day')),
            'situacao' => Tarefa::SITUACAO_EM_ANDAMENTO,
            'usuario_id' => 1,
        ];

        $tarefa = $this->Tarefa->save($this->Tarefa->newEntity($data));
        $this->assertFalse($tarefa, 'A data de encerramento não pode ser antes da data de criação.');
    }

    public function testValidacaoSituacao(): void
    {
        $tarefa = $this->Tarefa->newEntity(['situacao' => null]);
        $this->assertArrayHasKey('situacao', $tarefa->getErrors(), 'A situação da tarefa não pode ser nula.');
    }
}
