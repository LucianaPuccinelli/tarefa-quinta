<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Usuarios extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('usuario');
        $table->addColumn('nome', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('senha', 'string', ['limit' => 255])
            ->addColumn('cpf', 'string', ['limit' => 11])
            ->addColumn('telefone', 'string', ['limit' => 15])
            ->addColumn('data_nascimento', 'date')
            ->addColumn('created', 'datetime', ['null' => true])
            ->addIndex(['cpf'], ['unique' => true])
            ->create();
    }
}
