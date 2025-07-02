<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\Tarefa;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Smalot\PdfParser\Parser;

class TarefaControllerTest extends TestCase
{
    use IntegrationTestTrait;

    private Table $tarefasTable;

    protected $fixtures = [
        'app.Tarefa',
        'app.Usuario',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->tarefasTable = TableRegistry::getTableLocator()->get('Tarefa');
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

    public function testAdd(): void
    {
        $data = [
            'descricao' => 'Nova Tarefa',
            'data_prevista' => date('Y-m-d', strtotime('+1 day')),
            'situacao' => Tarefa::SITUACAO_EM_ANDAMENTO,
            'usuario_id' => 1,
        ];
        $this->post('/tarefa/add', $data);

        $tarefa = $this->tarefasTable->find()->where(['descricao' => 'Nova Tarefa'])->first();
        $this->assertEquals('Nova Tarefa', $tarefa->descricao);
        $this->assertEquals(date('Y-m-d', strtotime('+1 day')), $tarefa->data_prevista->format('Y-m-d'));
        $this->assertEquals(Tarefa::SITUACAO_EM_ANDAMENTO, $tarefa->situacao);
        $this->assertEquals(1, $tarefa->usuario_id);
    }

    public function testEdit(): void
    {
        $data = [
            'descricao' => 'tarefa atualizada',
            'situacao' => Tarefa::SITUACAO_PENDENTE,
        ];
        $this->put('/tarefa/edit/1', $data);

        $usuario = $this->tarefasTable->find()->where(['id' => '1'])->first();
        $this->assertNotEmpty($usuario);
        $this->assertEquals('tarefa atualizada', $usuario->descricao);
        $this->assertEquals(Tarefa::SITUACAO_PENDENTE, $usuario->situacao);
    }

    public function testDelete(): void
    {
        $this->delete('/tarefa/delete/1');

        $usuario = $this->tarefasTable->find()->where(['id' => '1'])->first();
        $this->assertEmpty($usuario);
    }

    public function testExportPdf(): void
    {
        $tarefa = $this->tarefasTable->newEntity([
            'descricao' => 'Teste de Tarefa',
            'data_prevista' => date('Y-m-d', strtotime('+1 day')),
            'situacao' => Tarefa::SITUACAO_EM_ANDAMENTO,
            'usuario_id' => 1,
            'created' => date('Y-m-d'),
        ]);
        $this->tarefasTable->save($tarefa);

        $this->get('/tarefa/export-pdf/' . $tarefa->id);

        $this->assertResponseOk();
        $this->assertHeaderContains('Content-Disposition', 'attachment; filename="tarefa_' . $tarefa->id . '.pdf"');

        $parser = new Parser();
        $pdf = $parser->parseContent((string)$this->_response->getBody());
        $text = $pdf->getText();

        $this->assertStringContainsString('Detalhes da Tarefa', $text);
        $this->assertStringContainsString('ID: ' . $tarefa->id, $text);
        $this->assertStringContainsString('Descrição: ' . $tarefa->descricao, $text);
        $this->assertStringContainsString('Data Prevista: ' . $tarefa->data_prevista->format('d/m/Y'), $text);
        $this->assertStringContainsString('Situação: ' . Tarefa::listarTarefas()[$tarefa->situacao], $text);
    }
}
