<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Tarefa> $tarefa
 */
?>
<?php echo $this->Html->css('paginator.css'); ?>
<?php echo $this->Html->css('table.css'); ?>

<?= $this->Form->create(null, ['type' => 'get']) ?>
<div class="filters">
    <div class="filter-item">
        <?= $this->Form->control('data_inicio', [
            'label' => 'Data de criação',
            'type' => 'date',
            'value' => $this->request->getQuery('created'),
        ]) ?>
    </div>
    <div class="filter-item">
        <?= $this->Form->control('data_prevista', [
            'label' => 'Data Prevista',
            'type' => 'date',
            'value' => $this->request->getQuery('data_prevista'),
        ]) ?>
    </div>
    <div class="filter-item">
        <?= $this->Form->control('data_encerramento', [
            'label' => 'Data Encerramento',
            'type' => 'date',
            'value' => $this->request->getQuery('data_encerramento'),
        ]) ?>
    </div>
    <div class="filter-item">
        <?= $this->Form->control('situacao', [
            'label' => 'Situação',
            'options' => \App\Model\Entity\Tarefa::listarTarefas(),
            'empty' => 'Selecione',
            'value' => $this->request->getQuery('situacao'),
        ]) ?>
    </div>
    <div class="filter-item">
        <?= $this->Form->button(__('Filtrar')) ?>
    </div>
</div>
<?= $this->Form->end() ?>

<div class="tarefa index content">
    <?= $this->Html->link(__('Adicionar Tarefa'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tarefa') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Criado em']) ?></th>
                    <th><?= $this->Paginator->sort('data_prevista') ?></th>
                    <th><?= $this->Paginator->sort('data_encerramento') ?></th>
                    <th><?= $this->Paginator->sort('situacao') ?></th>
                    <th class="actions"><?= __('Opções') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefa as $tarefa) : ?>
                <tr>
                    <td><?= $this->Number->format($tarefa->id) ?></td>
                    <td><?= h($tarefa->created->format('d/m/Y')) ?></td>
                    <td><?= h($tarefa->data_prevista->format('d/m/Y')) ?></td>
                    <td><?= h($tarefa->data_encerramento ?
                            $tarefa->data_encerramento->format('d/m/Y') : 'Indefinido') ?></td>
                    <td><?= h(\App\Model\Entity\Tarefa::listarTarefas()[$tarefa->situacao]) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $tarefa->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $tarefa->id]) ?>
                        <?= $this->Form->postLink(
                            __('Deletar'),
                            ['action' => 'delete', $tarefa->id],
                            ['confirm' => 'Você tem certeza que deseja remover essa tarefa?']
                        ) ?>
                        <?= $this->Html->link(
                            __('Exportar PDF'),
                            ['action' => 'exportPdf', $tarefa->id],
                            ['class' => 'export-pdf']
                        ) ?>
                    </td>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Próximo') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}}
        tarefas de {{count}} totais')) ?></p>
    </div>
</div>
