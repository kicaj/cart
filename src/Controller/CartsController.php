<?php
namespace Cart\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cart\Model\Entity\Cart;

class CartsController extends AppController
{
    /**
     * Cart.
     *
     * @return \Cake\Http\Response|void Redirects or renders view otherwise.
     */
    public function index()
    {
        $cart = $this->Carts->find()->where([
            'Carts.id IS' => $this->getRequest()->getSession()->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.id',
                    'CartItems.cart_cart_id',
                    'CartItems.identifier',
                    'CartItems.price',
                    'CartItems.tax',
                    'CartItems.quantity',
                ])->contain([
                    'CartItemProducts' => function ($cart_item_product) {
                        return $cart_item_product->select($this->Carts->CartItems->CartItemProducts);
                    },
                ]);
            },
        ])->first();

        if (!is_null($cart)) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $cart = $this->Carts->patchEntity($cart, $this->request->getData());

                if ($this->Carts->save($cart)) {
                    return $this->redirect([
                        'action' => 'checkout',
                    ]);
                }
            }

            $this->loadModel('Cart.Deliveries');
            $deliveries = $this->Deliveries->find()->select([
                'Deliveries.id',
                'Deliveries.name',
                'Deliveries.cost',
            ]);

            $this->set(compact('cart', 'deliveries'));
        }
    }

    /**
     * Cart checkout.
     *
     * @return \Cake\Http\Response|void Redirects or renders view otherwise.
     */
    public function checkout()
    {
        if ($this->getRequest()->getSession()->check('Cart.id') === false) {
            return $this->redirect([
                'action' => 'index',
            ]);
        }

        $cart = $this->Carts->find()->where([
            'Carts.id' => $this->getRequest()->getSession()->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.id',
                    'CartItems.cart_cart_id',
                    'CartItems.identifier',
                    'CartItems.price',
                    'CartItems.tax',
                    'CartItems.quantity',
                ])->contain([
                    'CartItemProducts' => function ($cart_item_product) {
                        return $cart_item_product->select($this->Carts->CartItems->CartItemProducts);
                    },
                ]);
            },
            'CustomerAddresses',
            'Deliveries',
        ])->first();

        if (!is_null($cart)) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $cart = $this->Carts->patchEntity($cart, $this->request->getData(), [
                    'associated' => ['CustomerAddresses']
                ]);

                $cart->status = Cart::STATUS_NEW;
                $cart->payment = Cart::PAYMENT_STARTED;

                if ($this->Carts->save($cart)) {
                    $cart = $cart->toArray();

                    $this->getEventManager()->dispatch(new Event('Cart.payment', $this, compact('cart')));
                }
            }

            $this->set(compact('cart'));
        } else {
            return $this->redirect([
                'action' => 'index',
            ]);
        }
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
            $this->Flash->success(__d('cart', 'Successfully has been added to cart!'));
        } else {
            $this->Flash->error(__d('cart', 'Could not be added. Please, try again.'));
        }

        if ($redirect = $this->getRequest()->getQuery('redirect')) {
            return $this->redirect($redirect);
        } elseif ($redirect = $this->getRequest()->referer()) {
            return $this->redirect($redirect);
        }

        return $this->redirect([
            'action' => 'index',
        ]);
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
                $this->Flash->success(__d('cart', 'Successfully has been changed in cart!'));
            } else {
                $this->Flash->error(__d('cart', 'Could not be changed. Please, try again.'));
            }
        }

        if ($redirect = $this->getRequest()->referer()) {
            return $this->redirect($redirect);
        }

        return $this->redirect([
            'action' => 'index',
        ]);
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
                $this->Flash->success(__d('cart', 'Successfully has been removed from cart!'));
            } else {
                $this->Flash->error(__d('cart', 'Could not be removed. Please, try again.'));
            }
        }

        if ($redirect = $this->getRequest()->referer()) {
            return $this->redirect($redirect);
        }

        return $this->redirect([
            'action' => 'index',
        ]);
    }

    /**
     * Pay.
     */
    public function pay()
    {
        $cart = $this->Carts->find()->where([
            'Carts.id' => $this->getRequest()->getSession()->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.id',
                    'CartItems.cart_cart_id',
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
                    'status' => Cart::STATUS_NEW,
                    'payment' => Cart::PAYMENT_STARTED,
                ]);

                if ($this->Carts->save($cart)) {
                    $cart = $cart->toArray();

                    $this->getEventManager()->dispatch(new Event('Cart.payment', $this, compact('cart')));
                }
            }
        }

        $this->redirect($this->getRequest()->referer());
    }
}
