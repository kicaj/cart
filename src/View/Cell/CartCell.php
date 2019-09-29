<?php
namespace Cart\View\Cell;

use Cake\View\Cell;
use Cart\Model\Table\CartsTable;

class CartCell extends Cell
{

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        $this->loadModel('Cart.Carts');

        $this->Carts->refresh($this->request->getSession());
    }

    /**
     * Cart summary.
     */
    public function display()
    {
        $cart = $this->Carts->find()->select([
            'Carts.' . $this->Carts->getPrimaryKey(),
        ])->where([
            'Carts.' . $this->Carts->getPrimaryKey() => $this->request->getSession()->read('Cart.id'),
            'Carts.status' => CartsTable::CART_STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.' . $this->Carts->CartItems->getPrimaryKey(),
                    'CartItems.cart_id',
                    'CartItems.price',
                    'CartItems.quantity',
                ]);
            },
        ]);

        $summary = 0;

        if (!$cart->isEmpty()) {
            $cart = $cart->first();

            foreach ($cart->cart_items as $cart_items) {
                $summary += $cart_items['price'] * $cart_items['quantity'];
            }
        }

        $this->set(compact('summary'));
    }

    /**
     * Add item to cart.
     *
     * @param mixed $item Unique identifier of item.
     * @param string|null $label Anchor label.
     * @param array $options Options are the same of HtmlHelper::link() method.
     */
    public function add($item, string $label = null, array $options = [])
    {
        $link = [
            'prefix' => false,
            'plugin' => 'Cart',
            'controller' => 'Carts',
            'action' => 'add',
            $item,
        ];

        if (is_null($label)) {
            $label = __d('cart', 'Add to cart');
        }

        $this->set(compact('link', 'label', 'options'));
    }

    /**
     * Change quantity of item in cart.
     *
     * @param mixed $item Unique identifier of item.
     * @param int $quantity Quantity of item.
     * @param string|null $label Anchor label.
     * @param array $options Options are the same of HtmlHelper::link() method.
     */
    public function change($item, int $quantity = 1, string $label = null, array $options = [])
    {
        $link = [
            'prefix' => false,
            'plugin' => 'Cart',
            'controller' => 'Carts',
            'action' => 'change',
            $item,
        ];

        if (is_null($label)) {
            $label = __d('cart', 'Change');
        }

        $this->set(compact('link', 'quantity', 'label', 'options'));
    }

    /**
     * Remove item from cart.
     *
     * @param mixed $item Unique identifier of item.
     * @param string|null $label Anchor label.
     * @param array $options Options are the same of HtmlHelper::link() method.
     */
    public function remove($item, string $label = null, array $options = [])
    {
        $link = [
            'prefix' => false,
            'plugin' => 'Cart',
            'controller' => 'Carts',
            'action' => 'remove',
            $item,
        ];

        if (is_null($label)) {
            $label = __d('cart', 'Remove');
        }

        $this->set(compact('link', 'label', 'options'));
    }
}
