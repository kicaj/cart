<?php
namespace Cart\View\Cell;

use Cake\View\Cell;
use Cart\Model\Entity\Cart;

class CartCell extends Cell
{

    /**
     * {@inheritDoc}
     */
    public function initialize(): void
    {
        $this->Carts = $this->fetchTable('Cart.Carts');

        $this->Carts->refresh($this->request->getSession());
    }

    /**
     * Cart summary.
     */
    public function display()
    {
        $cart = $this->Carts->find()->select([
            'Carts.' . $this->Carts->getPrimaryKey(),
            'Carts.items',
            'Carts.amount',
        ])->where([
            'Carts.' . $this->Carts->getPrimaryKey() . ' IS' => $this->request->getSession()->read('Cart.id'),
            'Carts.status' => Cart::STATUS_OPEN,
        ])->contain([
            'CartItems' => function ($cart_items) {
                return $cart_items->select([
                    'CartItems.cart_cart_id',
                    'CartItems.price',
                    'CartItems.tax',
                    'CartItems.quantity',
                ]);
            },
        ])->first();

        if (is_null($cart)) {
            $cart = $this->Carts->newEntity([
                'cart_items' => [],
            ]);
        }

        $this->set(compact('cart'));
    }

    /**
     * Add item to cart link.
     *
     * @param mixed $item Unique identifier of item.
     * @param string|null $title Anchor text.
     * @param array<string, mixed> $options Options are the same as at HtmlHelper::link() method.
     */
    public function add($item, string $title = null, array $options = [])
    {
        $url = [
            'prefix' => false,
            'plugin' => 'Cart',
            'controller' => 'Carts',
            'action' => 'add',
            $item,
        ];

        if (isset($options['redirect'])) {
            $url['?']['redirect'] = $options['redirect'];
        }

        if (is_null($title)) {
            $title = __d('cart', 'Add to cart');
        }

        $this->set(compact('title', 'url', 'options'));
    }

    /**
     * Change quantity of item in cart form.
     *
     * @param mixed $item Unique identifier of item.
     * @param int $quantity Quantity of item.
     * @param string|null $caption Button text.
     * @param array<string, mixed> $options Options are the same of HtmlHelper::link() method.
     */
    public function change($item, int $quantity = 1, string $caption = null, array $options = [])
    {
        $url = [
            'prefix' => false,
            'plugin' => 'Cart',
            'controller' => 'Carts',
            'action' => 'change',
            $item,
        ];

        if (is_null($caption)) {
            $caption = __d('cart', 'Change');
        }

        $this->set(compact('url', 'quantity', 'caption', 'options'));
    }

    /**
     * Remove item from cart post link.
     *
     * @param mixed $item Unique identifier of item.
     * @param string|null $title Anchor text.
     * @param array<string, mixed> $options Options are the same of HtmlHelper::link() method.
     */
    public function remove($item, string $title = null, array $options = [])
    {
        $url = [
            'prefix' => false,
            'plugin' => 'Cart',
            'controller' => 'Carts',
            'action' => 'remove',
            $item,
        ];

        if (is_null($title)) {
            $title = __d('cart', 'Remove');
        }

        $this->set(compact('title', 'url', 'options'));
    }
}
