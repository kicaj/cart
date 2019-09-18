<?php
namespace Cart\Model\Table;

use Cake\ORM\Table;
use Cake\Http\Session;
use Cake\ORM\Entity;
use Cake\Http\Exception\NotFoundException;

class CartsTable extends Table
{

    /**
     * Cart statuses.
     */
    const CART_STATUS_REJECT = -1;
    const CART_STATUS_OPEN = 0;
    const CART_STATUS_COMPLET = 1;

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('carts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
                'Carts.user_id' => $session->read('Auth.id'),
                'Carts.status' => self::CART_STATUS_OPEN,
            ])->order([
                'Carts.created' => 'DESC',
            ]);

            if (!$cart->isEmpty()) {
                echo 'aaa';
                $cart = $cart->first();

                $session->write('Cart.id', $cart->id);

                // Update session ID.
                if ($cart->session_id != $session->id()) {
                    // Update item.
                    $cart = $this->patchEntity($cart, [
                        'session_id' => $session->id(),
                    ]);

                    $this->save($cart);
                }
            }
        }
    }

    /**
     * Create new cart.
     *
     * @param string $session_id Session ID.
     * @param int|null $user_id User ID.
     * @return Entity Cart.
     */
    private function create(string $session_id, ?int $user_id): Entity
    {
        if (!is_null($user_id)) {
            $cart = $this->find()->select([
                'Carts.' . $this->getPrimaryKey(),
            ])->where([
                'Carts.user_id' => $user_id,
                'Carts.status' => self::CART_STATUS_OPEN,
            ])->order([
                'Carts.created' => 'DESC',
            ]);

            if (!$cart->isEmpty()) {
                $cart = $cart->first();

                // Reject old carts.
                $this->updateAll([
                    'status' => self::CART_STATUS_REJECT,
                ], [
                    $this->getPrimaryKey() .' !=' => $cart->id,
                    'user_id' => $user_id,
                    'status' => self::CART_STATUS_OPEN,
                ]);

                return $cart;
            }
        }

        $cart = [
            'session_id' => $session_id,
        ];

        if (!is_null($user_id)) {
            $cart['user_id'] = $user_id;
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
        ])->where([
            'Carts.' . $this->getPrimaryKey() => $session->read('Cart.id'),
            'Carts.status' => self::CART_STATUS_OPEN,
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
                        'quantity' => $quantity,
                    ],
                ],
            ]);
        }

        // Update user ID.
        if (empty($cart->user_id) && $user_id = $session->read('Auth.id')) {
            $cart->user_id = $user_id;
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
            'Carts.status' => self::CART_STATUS_OPEN,
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
            if (empty($cart->user_id) && $user_id = $session->read('Auth.id')) {
                $cart->user_id = $user_id;
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
            'Carts.status' => self::CART_STATUS_OPEN,
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
            if ($this->CartItems->deleteOrFail($cart->cart_items[0])) {
                return true;
            }
        }

        return false;
    }
}
