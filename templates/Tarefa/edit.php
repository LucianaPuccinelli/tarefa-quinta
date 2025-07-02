<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tarefa $tarefa
 * @var string[]|\Cake\Collection\CollectionInterface $usuario
 */
?>
<?php echo $this->Html->css('form-add.css'); ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Opções') ?></h4>
            <?= $this->Form->postLink(
                __('Deletar'),
                ['action' => 'delete', $tarefa->id],
                ['confirm' => 'Você tem certeza que deseja remover essa tarefa?', 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Listar Tarefas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tarefa form content">
            <?= $this->Form->create($tarefa) ?>
            <fieldset>
                <legend><?= __('Edit Tarefa') ?></legend>
                <?php
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('data_prevista');
                    echo $this->Form->control('data_encerramento', ['empty' => true]);
                    echo $this->Form->control('situacao', [
                        'type' => 'select',
                        'options' => \App\Model\Entity\Tarefa::listarTarefas(),
                        'label' => 'Situação',
                        'empty' => false,
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
