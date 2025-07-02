<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Tarefa;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tarefa Model
 *
 * @property \App\Model\Table\UsuarioTable&\Cake\ORM\Association\BelongsTo $Usuario
 * @method \App\Model\Entity\Tarefa newEmptyEntity()
 * @method \App\Model\Entity\Tarefa newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Tarefa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tarefa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tarefa findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Tarefa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tarefa[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tarefa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tarefa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tarefa[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tarefa[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tarefa[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tarefa[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TarefaTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tarefa');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuario', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('descricao')
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->date('data_prevista')
            ->requirePresence('data_prevista', 'create')
            ->notEmptyDate('data_prevista');

        $validator
            ->date('data_encerramento')
            ->allowEmptyDate('data_encerramento');

        $validator
            ->integer('situacao')
            ->requirePresence('situacao', 'create')
            ->notEmptyString('situacao')
            ->add('situacao', 'validValue', [
                'rule' => ['inList', [Tarefa::SITUACAO_PENDENTE, Tarefa::SITUACAO_EM_ANDAMENTO, Tarefa::SITUACAO_CONCLUIDA]],
                'message' => 'Situação deve ser 0, 1 ou 2.',
            ]);

        $validator
            ->integer('usuario_id')
            ->notEmptyString('usuario_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('usuario_id', 'Usuario'), ['errorField' => 'usuario_id']);

        $rules->add(function ($entity, $options) {
            if (!empty($entity->data_encerramento)) {
                if ($entity->isNew()) {
                    return strtotime((string)$entity->data_encerramento) >= strtotime((string)date('Y-m-d'));
                }

                $tarefa = $this->get($entity->id);
                if ($tarefa && strtotime((string)$entity->data_encerramento) < strtotime((string)$tarefa->created)) {
                    return false;
                }
            }

            return true;
        }, 'dataEncerramentoValida', [
            'errorField' => 'data_encerramento',
            'message' => 'A data de encerramento não pode ser antes da data de criação.'
        ]);

        $rules->add(function ($entity, $options) {
            if (!empty($entity->data_prevista)) {
                if ($entity->isNew()) {
                    return strtotime((string)$entity->data_prevista) >= strtotime((string)date('Y-m-d'));
                }

                $tarefa = $this->get($entity->id);
                if ($tarefa && strtotime((string)$entity->data_prevista) < strtotime((string)$tarefa->created)) {
                    return false;
                }
            }

            return true;
        }, 'dataPrevistaValida', [
            'errorField' => 'data_prevista',
            'message' => 'A data prevista não pode ser antes da data de criação.'
        ]);

        return $rules;
    }

    public function findUserTarefa(Query $query, array $options)
    {
        $usuario_id = $options['usuario_id'];

        return $query->where(['Tarefa.usuario_id' => $usuario_id]);
    }
}
