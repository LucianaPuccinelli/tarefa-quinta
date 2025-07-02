<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 */
?>
<?php echo $this->Html->css('form-add.css'); ?>
<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'); ?>
<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js'); ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= ('Opções') ?></h4>
            <?= $this->Html->link(('Editar Usuario'), ['action' => 'edit', $usuario->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(('Deletar Usuario'), ['action' => 'delete', $usuario->id], ['confirm' => ('Você tem certeza que deseja remover o usuário?'), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(('Listar Usuario'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(('Novo Usuario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usuario view content">
            <h3><?= h($usuario->nome) ?></h3>
            <table>
                <tr>
                    <th><?= ('Id') ?></th>
                    <td><?= $this->Number->format($usuario->id) ?></td>
                </tr>
                <tr>
                    <th><?= ('Nome') ?></th>
                    <td><?= h($usuario->nome) ?></td>
                </tr>
                <tr>
                    <th><?= ('Email') ?></th>
                    <td><?= h($usuario->email) ?></td>
                </tr>
                <tr>
                    <th><?= ('CPF') ?></th>
                    <td class="cpf"><?= h($usuario->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= ('Telefone') ?></th>
                    <td class="telefone"><?= h($usuario->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= ('Data Nascimento') ?></th>
                    <td><?= h($usuario->data_nascimento->format('d/m/Y')) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Tarefas Relacionadas') ?></h4>
                <?php if (!empty($usuario->tarefa)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Descricao') ?></th>
                            <th><?= __('Data Criacao') ?></th>
                            <th><?= __('Data Prevista') ?></th>
                            <th><?= __('Data Encerramento') ?></th>
                            <th><?= __('Situacao') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->tarefa as $tarefa) : ?>
                        <tr>
                            <td><?= h($tarefa->id) ?></td>
                            <td><?= h($tarefa->descricao) ?></td>
                            <td><?= h($tarefa->data_criacao->format('d/m/Y')) ?></td>
                            <td><?= h($tarefa->data_prevista->format('d/m/Y')) ?></td>
                            <td><?= h($tarefa->data_encerramento->format('d/m/Y')) ?></td>
                            <td><?= h($tarefa->situacao) ?></td>
                            <td><?= h($tarefa->usuario_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Tarefa', 'action' => 'view', $tarefa->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Tarefa', 'action' => 'edit', $tarefa->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Tarefa', 'action' => 'delete', $tarefa->id], ['confirm' => 'Você tem certeza que deseja remover essa tarefa?']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.cpf').mask('000.000.000-00');
        $('.telefone').mask('(00) 00000-0000');
    });
</script>
