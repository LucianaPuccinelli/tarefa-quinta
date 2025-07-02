<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TarefaFixture
 */
class TarefaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'tarefa';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'data_prevista' => '2025-05-07',
                'data_encerramento' => '2025-05-07',
                'situacao' => 1,
                'usuario_id' => 1,
                'created' => '2025-05-07'
            ],
        ];
        parent::init();
    }
}
