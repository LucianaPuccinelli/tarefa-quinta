<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Tarefa extends AbstractMigration
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
        $table = $this->table('tarefa');
        $table->addColumn('descricao', 'text')
            ->addColumn('data_prevista', 'date')
            ->addColumn('data_encerramento', 'date', ['null' => true])
            ->addColumn('situacao', 'integer')
            ->addColumn('usuario_id', 'integer')
            ->addForeignKey('usuario_id', 'usuario', 'id', [
                'delete'=> 'CASCADE',
                'update'=> 'CASCADE'
            ])
            ->addColumn('created', 'date')
            ->create();
    }
}
