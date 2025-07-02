<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Tarefa;
use Cake\Mailer\Mailer;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Tarefa Controller
 *
 * @property \App\Model\Table\TarefaTable $Tarefa
 * @method \App\Model\Entity\Tarefa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TarefaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $usuarioId = $this->Auth->user('id');
        $query = $this->Tarefa->find('userTarefa', [
            'usuario_id' => $usuarioId,
        ]);

        $created = $this->request->getQuery('created');
        $dataPrevista = $this->request->getQuery('data_prevista');
        $dataEncerramento = $this->request->getQuery('data_encerramento');
        $situacao = $this->request->getQuery('situacao');

        if ($created !== null && $created !== '') {
            $query->where(['Tarefa.created =' => $created]);
        }

        if ($dataPrevista !== null && $dataPrevista !== '') {
            $query->where(['Tarefa.data_prevista =' => $dataPrevista]);
        }

        if ($dataEncerramento !== null && $dataEncerramento !== '') {
            $query->where(['Tarefa.data_encerramento =' => $dataEncerramento]);
        }

        if ($situacao !== null && $situacao !== '') {
            $query->where(['Tarefa.situacao' => (int)$situacao]);
        }

        $tarefa = $this->paginate($query, [
            'limit' => 5,
        ]);

        $this->set('tarefa', $tarefa);
    }

    /**
     * View method
     *
     * @param string|null $id Tarefa id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tarefa = $this->Tarefa->get($id, [
            'contain' => ['Usuario'],
        ]);

        $this->set(compact('tarefa'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tarefa = $this->Tarefa->newEmptyEntity();
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');
            $tarefa = $this->Tarefa->patchEntity($tarefa, $this->request->getData());
            $tarefa->usuario_id = $userId;
            if ($this->Tarefa->save($tarefa)) {
                $this->Flash->success(__('A tarefa foi salva.'));
                $this->enviarEmailTarefa($tarefa);

                return $this->redirect(['action' => 'index']);
            }
            debug($tarefa->getErrors());
            $this->Flash->error(__('A tarefa não pode ser salva. Por favor, tente novamente.'));
        }
        $usuario = $this->Tarefa->Usuario->find('list', ['limit' => 200])->all();
        $this->set(compact('tarefa', 'usuario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tarefa id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tarefa = $this->Tarefa->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tarefa = $this->Tarefa->patchEntity($tarefa, $this->request->getData());
            if ($this->Tarefa->save($tarefa)) {
                $this->enviarEmailTarefa($tarefa);
                $this->Flash->success(__('A tarefa foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A tarefa não pode ser salva. Por favor, tente novamente.'));
        }
        $usuario = $this->Tarefa->Usuario->find('list', ['limit' => 200])->all();
        $this->set(compact('tarefa', 'usuario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tarefa id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tarefa = $this->Tarefa->get($id);
        if ($this->Tarefa->delete($tarefa)) {
            $this->Flash->success(__('A tarefa foi removida.'));
        } else {
            $this->Flash->error(__('A tarefa não foi deletada. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * exportPdf method
     *
     * @param string|null $id Tarefa id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function exportPdf($id)
    {
        $tarefa = $this->Tarefa->get($id, [
            'contain' => ['Usuario'],
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $html = $this->renderView($tarefa);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();

        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="tarefa_' . $id . '.pdf"')
            ->withStringBody($output);
    }

    /**
     * renderView method
     *
     * @param null $tarefa Tarefa id.
     * @return string Redirects to index.
     */
    private function renderView($tarefa)
    {
        $output = '<h1>Detalhes da Tarefa</h1>';
        $output .= '<p><strong>ID:</strong> ' . $tarefa->id . '</p>';
        $output .= '<p><strong>Descrição:</strong> ' . $tarefa->descricao . '</p>';
        $output .= '<p><strong>Criado em:</strong> ' . $tarefa->created->format('d/m/Y') . '</p>';
        $output .= '<p><strong>Data Prevista:</strong> ' . $tarefa->data_prevista->format('d/m/Y') . '</p>';
        $output .= '<p><strong>Data Encerramento:</strong> ' . ($tarefa->data_encerramento ?
                $tarefa->data_encerramento->format('d/m/Y') : 'Indefinido') . '</p>';
        $output .= '<p><strong>Situação:</strong> ' . Tarefa::listarTarefas()[$tarefa->situacao] . '</p>';
        $output .= '<p><strong>Usuário:</strong> ' . $tarefa->usuario->nome . '</p>';

        return $output;
    }

    /**
     * enviarEmailTarefa method
     *
     * @param null $tarefa Tarefa id
     */
    private function enviarEmailTarefa($tarefa)
    {
        $usuario = $this->Auth->user();
        $email = new Mailer('default');
        $email->setTo($usuario['email'])
            ->setSubject('Tarefa Atualizada')
            ->setEmailFormat('html')
            ->setViewVars(['tarefa' => $tarefa, 'usuario' => $usuario])
            ->viewBuilder()->setTemplate('tarefa_notificacao');
        try {
            $email->send();
        } catch (\Exception $e) {
            \Cake\Log\Log::error('Erro ao enviar e-mail: ' . $e->getMessage());
        }
    }
}
