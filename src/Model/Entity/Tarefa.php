<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tarefa Entity
 *
 * @property int $id
 * @property string $descricao
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $data_prevista
 * @property \Cake\I18n\FrozenDate|null $data_encerramento
 * @property bool $situacao
 * @property int $usuario_id
 *
 * @property \App\Model\Entity\Usuario $usuario
 */
class Tarefa extends Entity
{
    public const SITUACAO_PENDENTE = 0;
    public const SITUACAO_EM_ANDAMENTO = 1;
    public const SITUACAO_CONCLUIDA = 2;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'descricao' => true,
        'created' => true,
        'data_prevista' => true,
        'data_encerramento' => true,
        'situacao' => true,
        'usuario_id' => true,
        'usuario' => true,
    ];

    public static function listarTarefas()
    {
        return [
            self::SITUACAO_PENDENTE => 'Pendente',
            self::SITUACAO_EM_ANDAMENTO => 'Em Andamento',
            self::SITUACAO_CONCLUIDA => 'Concluída',
        ];
    }
}
