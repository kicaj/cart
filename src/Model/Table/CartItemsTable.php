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

        $this->belongsTo('Cart.Carts');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Carts' => [
                'items',
            ],
        ]);
    }
}
