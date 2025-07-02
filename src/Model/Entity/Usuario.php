<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string $cpf
 * @property string $telefone
 * @property \Cake\I18n\FrozenDate $data_nascimento
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\Tarefa[] $tarefa
 */
class Usuario extends Entity
{
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
        'nome' => true,
        'email' => true,
        'senha' => true,
        'cpf' => true,
        'telefone' => true,
        'data_nascimento' => true,
        'created' => true,
        'tarefa' => true,
    ];

    protected $_hidden = [
        'senha',
    ];

    protected function _setPassword($value)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }
}
