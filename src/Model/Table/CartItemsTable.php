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
                'amount' => function ($event, $entity, $table, $original) {
                    $items = $table->find()->select([
                        'price',
                        'quantity'
                    ])->where([
                        'cart_id' => $entity->cart_id,
                    ])->toArray();

                    $amount = 0;

                    foreach ($items as $item) {
                        $amount += $item['price'] * $item['quantity'];
                    }

                    return $amount;
                }
            ],
        ]);
    }
}
