<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class DeliveriesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cart_deliveries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('tax')
            ->allowEmptyString('tax');

        $validator
            ->decimal('cost')
            ->requirePresence('cost', 'create')
            ->notEmptyString('cost');

        return $validator;
    }
}
