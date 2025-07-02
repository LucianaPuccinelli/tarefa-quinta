<h2>Olá, <?= h($usuario['nome']) ?>!</h2>
<p>Uma tarefa foi atualizada para você:</p>

<ul>
    <li><strong>ID:</strong> <?= $tarefa->id ?></li>
    <li><strong>Descrição:</strong> <?= h($tarefa->descricao) ?></li>
    <li><strong>Criado em:</strong> <?= $tarefa->created->format('d/m/Y') ?></li>
    <li><strong>Data Prevista:</strong> <?= $tarefa->data_prevista->format('d/m/Y') ?></li>
    <li><strong>Data Encerramento:</strong> <?= $tarefa->data_encerramento ? $tarefa->data_encerramento->format('d/m/Y') : 'Indefinido' ?></li>
    <li><strong>Situação:</strong> <?= \App\Model\Entity\Tarefa::listarTarefas()[$tarefa->situacao] ?></li>
</ul>

<p>Obrigado por usar nosso sistema!</p>
