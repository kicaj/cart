<?php
namespace Cart\Model\Table;

use Cake\ORM\Table;

class CartItemsTable extends Table
{

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cart_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cart.Carts');

        // @TODO Remove
        $this->belongsTo('Subscription', [
            'joinType' => 'INNER',
            'foreignKey' => 'item_revision_hash',
            'bindingKey' => 'revision_hash'
        ]);
    }
}
