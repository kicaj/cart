<?php
namespace Cart\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cart\Model\Entity\Cart;

class CartsController extends AppController
{

    /**
     * Carts.
     */
    public function index()
    {
        $carts = $this->paginate($this->Carts->find()->select([
            'Carts.' . $this->Carts->getPrimaryKey(),
            'Carts.customer_id',
            'Carts.items',
            'Carts.amount',
            'Carts.status',
            'Carts.created',
            'Carts.modified',
        ])->where([
            'Carts.status IN' => [
                Cart::CART_STATUS_NEW,
                Cart::CART_STATUS_PENDING,
                Cart::CART_STATUS_COMPLET,
                Cart::CART_STATUS_OPEN,
            ],
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.' . $this->Carts->CartItems->getPrimaryKey(),
                    'CartItems.cart_id',
                    'CartItems.identifier',
                    'CartItems.price',
                    'CartItems.quantity',
                ])->contain([
                    'CartItemProducts' => function ($cart_item_product) {
                        return $cart_item_product->select($this->Carts->CartItems->CartItemProducts);
                    },
                ]);
            },
        ]), [
            'order' => [
                'modified' => 'DESC',
            ],
            'sortWhitelist' => [
                $this->Carts->getPrimaryKey(),
                'items',
                'amount',
                'status',
                'modified',
            ],
        ]);

        $this->set(compact('carts'));
    }

    /**
     * View cart.
     *
     * @param string|null $id Cart identifier.
     */
    public function view($id = null)
    {
        $cart = $this->Carts->find()->select([
            'Carts.' . $this->Carts->getPrimaryKey(),
            'Carts.customer_id',
            'Carts.amount',
            'Carts.status',
            'Carts.modified',
        ])->where([
            'Carts.' . $this->Carts->getPrimaryKey() => $id,
            'Carts.status IN' => [
                Cart::CART_STATUS_NEW,
                Cart::CART_STATUS_PENDING,
                Cart::CART_STATUS_COMPLET,
                Cart::CART_STATUS_OPEN,
            ],
        ]);

        if (!$cart->isEmpty()) {
            $cart = $cart->first();

            $cartItems = $this->paginate($this->Carts->CartItems->find()->select([
                'CartItems.' . $this->Carts->CartItems->getPrimaryKey(),
                'CartItems.identifier',
                'CartItems.price',
                'CartItems.quantity',
                'CartItems.modified',
            ])->where([
                'CartItems.cart_id' => $cart->{$this->Carts->getPrimaryKey()}
            ]), [
                'order' => [
                    'CartItems.modified' => 'DESC',
                ],
                'sortWhitelist' => [
                    $this->Carts->CartItems->getPrimaryKey(),
                    'price',
                    'quantity',
                    'modified',
                ],
            ]);

            $this->set(compact('cart', 'cartItems'));
        } else {
            throw new NotFoundException();
        }
    }
}
