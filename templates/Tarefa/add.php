<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tarefa $tarefa
 * @var \Cake\Collection\CollectionInterface|string[] $usuario
 */
?>
<?php echo $this->Html->css('form-add.css'); ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Opções') ?></h4>
            <?= $this->Html->link(__('Listar Tarefas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tarefa form content">
            <?= $this->Form->create($tarefa) ?>
            <fieldset>
                <legend><?= __('Adicionar Tarefa') ?></legend>
                <?php
                    echo $this->Form->control('descricao', ['rows' => 3]);
                    echo $this->Form->control('data_prevista');
                    echo $this->Form->control('data_encerramento', ['empty' => true]);
                    echo $this->Form->control('situacao', [
                    'type' => 'select',
                    'options' => \App\Model\Entity\Tarefa::listarTarefas(),
                    'default' => \App\Model\Entity\Tarefa::SITUACAO_EM_ANDAMENTO,
                    'empty' => false,
                    'label' => 'Situação'
                ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
