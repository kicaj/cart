<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerAddresses Model
 *
 * @property \Cart\Model\Table\CartsTable&\Cake\ORM\Association\BelongsTo $Carts
 *
 * @method \Cart\Model\Entity\CustomerAddress get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\CustomerAddress newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\CustomerAddress[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\CustomerAddress|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\CustomerAddress saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\CustomerAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\CustomerAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\CustomerAddress findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomerAddressesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('customer_addresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Carts', [
            'foreignKey' => 'cart_id',
            'joinType' => 'INNER',
            'className' => 'Cart.Carts',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('street')
            ->maxLength('street', 255)
            ->requirePresence('street', 'create')
            ->notEmptyString('street');

        $validator
            ->integer('postal')
            ->requirePresence('postal', 'create')
            ->notEmptyString('postal');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->integer('country')
            ->requirePresence('country', 'create')
            ->notEmptyString('country');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['cart_id'], 'Carts'));

        return $rules;
    }
}
