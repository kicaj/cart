<?php
namespace Cart\Model\Table;

use Cake\ORM\Table;
use Cake\Http\Session;
use Cake\ORM\Entity;
use Cake\Http\Exception\NotFoundException;
use Cart\Model\Entity\Cart;

class CartsTable extends Table
{

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('carts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cart.Deliveries');

        $this->hasOne('Cart.CustomerAddresses');

        $this->hasMany('Cart.CartItems');
    }

    /**
     * Refresh cart.
     *
     * @param Session $session Session data.
     */
    public function refresh(Session $session): void
    {
        if ($session->check('Auth.id')) {
            $cart = $this->find()->select([
                'Carts.' . $this->getPrimaryKey(),
                'Carts.session_id',
            ])->where([
                'Carts.customer_id' => $session->read('Auth.id'),
                'Carts.status' => Cart::STATUS_OPEN,
            ])->order([
                'Carts.created' => 'DESC',
            ]);

            if (!$cart->isEmpty()) {
                $cart = $cart->first();

                if (!$session->check('Cart.id')) {
                    $session->write('Cart.id', $cart->id);
                } else {
                    if ($session->read('Cart.id') !== $cart->id) {
                        // Merge older open carts.
                        $carts = $this->find()->select([
                            'Carts.' . $this->getPrimaryKey(),
                        ])->where([
                            'Carts.customer_id' => $session->read('Auth.id'),
                            'Carts.status' => Cart::STATUS_OPEN,
                        ])->contain([
                            'CartItems' => function ($cart_items) {
                                return $cart_items->select([
                                    'CartItems.' . $this->CartItems->getPrimaryKey(),
                                    'CartItems.cart_id',
                                    'CartItems.identifier',
                                    'CartItems.quantity',
                                ]);
                            },
                        ]);

                        if (!$carts->isEmpty()) {
                            array_map(function ($cart) use ($session) {
                                // Set cart status to merged
                                $this->updateAll([
                                    'status' => Cart::STATUS_MERGED,
                                ], [
                                    $this->getPrimaryKey() => $cart->id,
                                ]);

                                // Add earlier added items to cart.
                                if (!empty($cart_items = $cart->cart_items)) {
                                    foreach ($cart_items as $cart_item) {
                                        $this->add($session, $cart_item->identifier, $cart_item->quantity);
                                    }
                                }
                            }, $carts->all()->toArray());
                        }

                        // Update session ID.
                        $cart = $this->patchEntity($cart, [
                            $this->getPrimaryKey() => $session->read('Cart.id'),
                            'session_id' => $session->id(),
                        ]);

                        $this->save($cart);
                    }
                }
            }
        } else {
            if ($session->check('Cart.id')) {
                $cart = $this->find()->select([
                    'Carts.' . $this->getPrimaryKey(),
                    'Carts.customer_id',
                ])->where([
                    'Carts.' . $this->getPrimaryKey() => $session->read('Cart.id'),
                    'Carts.status' => Cart::STATUS_OPEN,
                ]);

                if (!$cart->isEmpty()) {
                    $cart = $cart->first();

                    if (!empty($cart->customer_id)) {
                        $session->delete('Cart.id');
                    }
                }
            }
        }
    }

    /**
     * Create new cart.
     *
     * @param string $session_id Session identifier.
     * @param int|null $customer_id Customer identifier.
     * @return Entity Cart.
     */
    private function create(string $session_id, ?int $customer_id): Entity
    {
        if (!is_null($customer_id)) {
            $cart = $this->find()->select([
                'Carts.' . $this->getPrimaryKey(),
            ])->where([
                'Carts.customer_id' => $customer_id,
                'Carts.status' => Cart::STATUS_OPEN,
            ])->order([
                'Carts.created' => 'DESC',
            ]);

            if (!$cart->isEmpty()) {
                $cart = $cart->first();

                // Reject old carts.
                $this->updateAll([
                    'status' => Cart::STATUS_REJECTED,
                ], [
                    $this->getPrimaryKey() .' !=' => $cart->id,
                    'customer_id' => $customer_id,
                    'status' => Cart::STATUS_OPEN,
                ]);

                return $cart;
            }
        }

        $cart = [
            'session_id' => $session_id,
        ];

        if (!is_null($customer_id)) {
            $cart['customer_id'] = $customer_id;
        }

        $cart = $this->newEntity($cart);

        if ($this->save($cart)) {
            return $cart;
        }
    }

    /**
     * Add item to cart.
     *
     * @param Session $session Session data.
     * @param string $identifier Unique identifier of item.
     * @param int $quantity Quantit of itemy.
     * @throws NotFoundException
     * @return bool True, if it is successful.
     */
    public function add(Session $session, string $identifier, int $quantity = 1): bool
    {
        $item = $this->CartItems->CartItemProducts->find()->where([
            'CartItemProducts.' . $this->CartItems->CartItemProducts->getBindingKey() => $identifier,
        ]);

        if ($item->isEmpty()) {
            throw new NotFoundException();
        }

        $cart = $this->find()->select([
            'Carts.' . $this->getPrimaryKey(),
            'Carts.session_id',
        ])->where([
            'Carts.' . $this->getPrimaryKey() . ' IS' => $session->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) use ($identifier) {
                return $cart_items->select([
                    'CartItems.' . $this->CartItems->getPrimaryKey(),
                    'CartItems.cart_id',
                    'CartItems.quantity',
                ])->where([
                    'CartItems.identifier' => $identifier,
                ]);
            },
        ])->first();

        if (!$cart) {
            $cart = $this->create($session->id(), $session->read('Auth.id'));

            $session->write('Cart.id', $cart->id);
        }

        if ($cart->cart_items) {
            if ($quantity < 1) {
                $quantity = 1;
            }

            $cart->cart_items[0]['quantity'] += $quantity;

            // Update item.
            $cart = $this->patchEntity($cart, $cart->toArray());
        } else {
            // Add new item.
            $cart = $this->patchEntity($cart, [
                'cart_items' => [
                    [
                        'identifier' => $identifier,
                        'price' => $item->first()->price,
                        'tax' => $item->first()->tax,
                        'quantity' => $quantity,
                    ],
                ],
            ]);
        }

        // Update user ID.
        if (empty($cart->customer_id) && $customer_id = $session->read('Auth.id')) {
            $cart->customer_id = $customer_id;
        }

        if ($this->save($cart)) {
            return true;
        }

        return false;
    }

    /**
     * Change quantity of item in cart.
     *
     * @param Session $session Session data.
     * @param string $identifier Unique identifier of item.
     * @param int $quantity Quantit of itemy.
     * @return bool True, if it is successful.
     */
    public function change(Session $session, string $identifier, int $quantity = 1): bool
    {
        $cart = $this->find()->select([
            'Carts.' . $this->getPrimaryKey(),
        ])->where([
            'Carts.' . $this->getPrimaryKey() => $session->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) use ($identifier) {
                return $cart_items->select([
                    'CartItems.' . $this->CartItems->getPrimaryKey(),
                    'CartItems.cart_id',
                    'CartItems.quantity',
                ])->where([
                    'CartItems.identifier' => $identifier,
                ]);
            },
        ])->first();

        if ($cart->cart_items) {
            if ($quantity < 1) {
                $quantity = 1;
            }

            $cart->cart_items[0]['quantity'] = $quantity;

            // Update item.
            $cart = $this->patchEntity($cart, $cart->toArray());

            // Update user ID.
            if (empty($cart->customer_id) && $customer_id = $session->read('Auth.id')) {
                $cart->customer_id = $customer_id;
            }

            if ($this->save($cart)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Delete item from cart.
     *
     * @param Session $session Session data.
     * @param string $identifier Unique identifier of item.
     * @return bool True, if it is successful.
     */
    public function remove(Session $session, string $identifier, int $quantity = 1): bool
    {
        $cart = $this->find()->select([
            'Carts.' . $this->getPrimaryKey(),
        ])->where([
            'Carts.' . $this->getPrimaryKey() => $session->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) use ($identifier) {
                return $cart_items->select([
                    'CartItems.' . $this->CartItems->getPrimaryKey(),
                    'CartItems.cart_id',
                ])->where([
                    'CartItems.identifier' => $identifier,
                ]);
            },
        ])->first();

        if ($cart->cart_items) {
            if ($this->CartItems->deleteOrFail($cart->cart_items[0])) {
                return true;
            }
        }

        return false;
    }
}
