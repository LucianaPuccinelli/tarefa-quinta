<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tarefa $tarefa
 */
?>
<?php echo $this->Html->css('form-add.css'); ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Opções') ?></h4>
            <?= $this->Html->link(__('Editar Tarefa'), ['action' => 'edit', $tarefa->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Deletar Tarefa'), ['action' => 'delete', $tarefa->id], ['confirm' => 'Você tem certeza que deseja remover essa tarefa?', 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Listar Tarefas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Nova Tarefa'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tarefa view content">
            <h3><?= h($tarefa->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tarefa->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuario') ?></th>
                    <td><?= $tarefa->has('usuario') ? $this->Html->link($tarefa->usuario->nome, ['controller' => 'Usuario', 'action' => 'view', $tarefa->usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Criacao') ?></th>
                    <td><?= h($tarefa->created->format('d/m/Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Prevista') ?></th>
                    <td><?= h($tarefa->data_prevista->format('d/m/Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Encerramento') ?></th>
                    <td><?= h($tarefa->data_encerramento ? $tarefa->data_encerramento->format('d/m/Y') : 'Indefinido') ?></td>
                </tr>
                <tr>
                    <th><?= __('Situacao') ?></th>
                    <td><?= h(\App\Model\Entity\Tarefa::listarTarefas()[$tarefa->situacao]) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tarefa->descricao)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
