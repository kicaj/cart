<?php
namespace Cart\Model\Table;

use Cake\ORM\Table;

class CartItemsTable extends Table
{

    /**
     * @inheritdoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('cart_cart_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Cart.Carts', [
            'foreignKey' => 'cart_cart_id',
        ]);
        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Carts' => [
                'items' => function ($event, $entity, $table, $original) {
                    $items = $table->find()->select([
                        'itemsa' => $table->find()->func()->sum('quantity'),
                    ])->where([
                        'cart_cart_id' => $entity->cart_cart_id,
                    ])->first();

                    return $items['itemsa'];
                },
                'amount' => function ($event, $entity, $table, $original) {
                    $items = $table->find()->select([
                        'price',
                        'quantity',
                    ])->where([
                        'cart_cart_id' => $entity->cart_cart_id,
                    ])->all();

                    $amount = 0;

                    foreach ($items as $item) {
                        $amount += $item['price'] * $item['quantity'];
                    }

                    return $amount;
                },
            ],
        ]);
    }
}
