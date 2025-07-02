<?php echo $this->Html->css('styles.css'); ?>

<div class="container">
    <h1>Escolha o que deseja fazer</h1>
    <div class="button-group">
        <a href="<?= $this->Url->build(['controller' => 'Usuario', 'action' => 'index']); ?>" class="btn"><i class="fa-solid fa-user"></i> Usuários</a>
        <a href="<?= $this->Url->build(['controller' => 'Tarefa', 'action' => 'index']); ?>" class="btn"><i class="fa-solid fa-tag"></i> Tarefas</a>
    </div>
</div>
