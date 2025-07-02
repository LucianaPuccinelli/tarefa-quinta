<?php echo $this->Html->css('styles.css'); ?>

<div class="login-container">
    <h1>Login</h1>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['label' => false, 'placeholder' => 'Email', 'class' => 'login-input']) ?>
    <?= $this->Form->control('senha', ['label' => false, 'type' => 'password', 'placeholder' => 'Senha', 'class' => 'login-input']) ?>
    <?= $this->Form->button('Login', ['class' => 'btn-login']) ?><br>
    <a href="<?= $this->Url->build(['controller' => 'Usuario', 'action' => 'add']); ?>">Cadastrar</a>
    <?= $this->Form->end() ?>
</div>
