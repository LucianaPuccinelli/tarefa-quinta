<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 */
?>
<?php echo $this->Html->css('form-add.css'); ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Opções') ?></h4>
            <?= $this->Html->link(__('Listar Usuarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usuario form content">
            <?= $this->Form->create($usuario) ?>
            <fieldset>
                <legend><?= __('Adicionar Usuario') ?></legend>
                <?php
                    echo $this->Form->control('nome');
                    echo $this->Form->control('email');
                    echo $this->Form->control('senha', ['type' => 'password']);
                    echo $this->Form->control('cpf', ['id' => 'cpf']);
                    echo $this->Form->control('telefone', ['id' => 'telefone']);
                    echo $this->Form->control('data_nascimento');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(document.getElementById('cpf'), {
        mask: '000.000.000-00'
    });

    IMask(document.getElementById('telefone'), {
        mask: '(00) 00000-0000'
    });
</script>
