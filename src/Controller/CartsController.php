<?php
namespace Cart\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cart\Model\Entity\Cart;

class CartsController extends AppController
{

    /**
     * Cart.
     */
    public function index()
    {
        $cart = $this->Carts->find()->where([
            'Carts.' . $this->Carts->getPrimaryKey() => $this->getRequest()->getSession()->read('Cart.id'),
            'Carts.status' => Cart::CART_STATUS_OPEN,
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
        ])->first();

        $this->set(compact('cart'));
    }

    /**
     * Add item to cart.
     *
     * @param mixed $item Unique identifier of item.
     */
    public function add($item)
    {
        $quantity = 1;

        if ($this->getRequest()->is('post')) {
            $quantity = (int) $this->getRequest()->getData('quantity');
        }

        if ($this->Carts->add($this->getRequest()->getSession(), $item, $quantity)) {
            $this->Flash->success(__d('cart', 'Successfully added to cart!'));
        } else {
            $this->Flash->error(__d('cart', 'Could not be added. Please, try again.'));
        }

        if ($redirect = $this->getRequest()->getQuery('redirect')) {
            $this->redirect($redirect);
        }

        $this->redirect($this->referer());
    }

    /**
     * Change quantity of item in cart.
     *
     * @param mixed $item Unique identifier of item.
     */
    public function change($item)
    {
        if ($this->getRequest()->is('post')) {
            $quantity = (int) $this->getRequest()->getData('quantity');

            if ($this->Carts->change($this->getRequest()->getSession(), $item, $quantity)) {
                $this->Flash->success(__d('cart', 'Successfully changed in cart!'));
            } else {
                $this->Flash->error(__d('start', 'Could not be changed. Please, try again.'));
            }
        }

        $this->redirect($this->referer());
    }

    /**
     * Remove item from cart.
     *
     * @param mixed $item Unique identifier of item.
     */
    public function remove($item)
    {
        if ($this->getRequest()->is(['delete', 'post'])) {
            if ($this->Carts->remove($this->getRequest()->getSession(), $item)) {
                $this->Flash->success(__d('cart', 'Successfully deleted from cart!'));
            } else {
                $this->Flash->error(__d('cart', 'Could not be deleted. Please, try again.'));
            }
        }

        $this->redirect($this->referer());
    }

    public function pay()
    {
        $cart = $this->Carts->find()->where([
            'Carts.' . $this->Carts->getPrimaryKey() => $this->getRequest()->getSession()->read('Cart.id'),
            'Carts.status' => Cart::CART_STATUS_OPEN,
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
        ]);

        if (!$cart->isEmpty()) {
            $cart = $cart->first();

            if (!empty($cart->cart_items)) {
                $cart = $this->Carts->patchEntity($cart, [
                    'status' => Cart::CART_STATUS_NEW,
                ]);

                if ($this->Carts->save($cart)) {
                    $cart = $cart->toArray();

                    $this->getEventManager()->dispatch(new Event('Cart.payment', $this, compact('cart')));
                }
            }
        }

        $this->redirect($this->referer());
    }
}
