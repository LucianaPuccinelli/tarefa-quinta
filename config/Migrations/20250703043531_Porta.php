<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Porta extends AbstractMigration
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
        $table = $this->table('testes');
        $table->addColumn('teste1', 'string', ['limit' => 255])
            ->addColumn('teste2', 'string', ['limit' => 255])
            ->create();
    }
}
