<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Usuario> $usuario
 */
?>
<?php echo $this->Html->css('paginator.css'); ?>
<?php echo $this->Html->css('table.css'); ?>
<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'); ?>
<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js'); ?>

<div class="usuario index content">
    <?= $this->Html->link('Novo Usuario', ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Usuario') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('data_nascimento') ?></th>
                    <th class="actions"><?= __('Opções') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuario as $usuario) : ?>
                <tr>
                    <td><?= $this->Number->format($usuario->id) ?></td>
                    <td><?= h($usuario->nome) ?></td>
                    <td><?= h($usuario->email) ?></td>
                    <td class="cpf"><?= h($usuario->cpf) ?></td>
                    <td class="telefone"><?= h($usuario->telefone) ?></td>
                    <td><?= h($usuario->data_nascimento->format('d/m/Y')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Ver', ['action' => 'view', $usuario->id]) ?>
                        <?= $this->Html->link('Editar', ['action' => 'edit', $usuario->id]) ?>
                        <?= $this->Form->postLink(
                            'Deletar',
                            ['action' => 'delete', $usuario->id],
                            ['confirm' => 'Você tem certeza que deseja remover o usuário?']
                        ) ?>
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
        usuários de {{count}} totais')) ?></p>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.cpf').mask('000.000.000-00');
        $('.telefone').mask('(00) 00000-0000');
    });
</script>
