USE tarefa_quinta_test;

DELETE FROM tarefa;
DELETE FROM usuario;

INSERT INTO usuario (id, nome, email, senha, cpf, telefone, data_nascimento, created) VALUES
(1, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', '12345678909', 'Lorem ipsum d', '2025-05-07', '2025-05-07 03:56:30'),
(2, 'Usuario Teste Login', 'login@teste.com', '$2y$10$FNWFOtqqdljOBIA7P6cBn.TvxupsEB6IMmZrItREY70WfZM8hWZwO', '12345678901', '11987654321', '2000-01-01', '2025-05-07 03:56:30');

INSERT INTO tarefa (id, descricao, data_prevista, data_encerramento, situacao, usuario_id, created) VALUES
(1, 'Lorem ipsum dolor sit amet, aliquet feugiat...', '2025-05-07', '2025-05-07', 1, 1, '2025-05-07');
