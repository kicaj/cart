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
            'Carts.payment',
            'Carts.created',
            'Carts.modified',
        ])->where([
            'Carts.status !=' => Cart::STATUS_MERGED,
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
                'payment',
                'modified',
            ],
        ]);

        $this->set(compact('carts'));
    }

    /**
     * View cart.
     *
     * @param null|integer $id Cart identifier.
     */
    public function view($id = null)
    {
        $cart = $this->Carts->find()->where([
            'Carts.' . $this->Carts->getPrimaryKey() => $id,
            'Carts.status !=' => Cart::STATUS_MERGED,
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.cart_id',
                    'CartItems.price',
                    'CartItems.tax',
                    'CartItems.quantity',
                ])->contain([
                    'CartItemProducts' => function ($cart_item_product) {
                        return $cart_item_product->select($this->Carts->CartItems->CartItemProducts);
                    },
                ]);
            },
            'Deliveries' => function ($delivery) {
                return $delivery->select([
                    'Deliveries.name',
                    'Deliveries.tax',
                    'Deliveries.cost',
                ]);
            },
            'CustomerAddresses' => function ($customer_address) {
                return $customer_address->select([
                    'CustomerAddresses.street',
                    'CustomerAddresses.postal',
                    'CustomerAddresses.city',
                    'CustomerAddresses.country',
                ]);
            },
        ]);

        if (!$cart->isEmpty()) {
            $cart = $cart->first();

            $cart_items = $this->paginate($this->Carts->CartItems->find()->select([
                'CartItems.' . $this->Carts->CartItems->getPrimaryKey(),
                'CartItems.identifier',
                'CartItems.price',
                'CartItems.tax',
                'CartItems.quantity',
                'CartItems.modified',
            ])->where([
                'CartItems.cart_id' => $cart->{$this->Carts->getPrimaryKey()},
            ]), [
                'order' => [
                    'CartItems.modified' => 'DESC',
                ],
                'sortWhitelist' => [
                    'identifier',
                    'price',
                    'tax',
                    'quantity',
                    'modified',
                ],
            ]);

            $this->set(compact('cart', 'cart_items'));
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * Remove cart item.
     *
     * @param null|integer $cart_item_id Cart item identifier.
     */
    public function removeItem($cart_item_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $cartItem = $this->Carts->CartItems->find()->select([
            'CartItems.' . $this->Carts->CartItems->getPrimaryKey(),
            'CartItems.cart_id',
        ])->where([
            'CartItems.' . $this->Carts->CartItems->getPrimaryKey() => $cart_item_id,
        ]);

        if (!$cartItem->isEmpty()) {
            if ($this->Carts->CartItems->deleteOrFail($cartItem->first())) {
                $this->Flash->success(__d('admin', 'The element has been removed from cart1'));
            } else {
                $this->Flash->error(__d('admin', 'The element could not be removed. Please, try again.'));
            }

            return $this->redirect($this->getRequest()->referer());
        } else {
            throw new NotFoundException();
        }
    }
}
