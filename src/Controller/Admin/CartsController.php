<?php
namespace Cart\Controller\Admin;

use App\Controller\AppController;
use Cart\Model\Entity\Cart;

class CartsController extends AppController
{

    /**
     * Carts.
     */
    public function index()
    {
        $carts = $this->paginate($this->Carts->find()->/*select([
            'Carts.items',
        ])->*/where([
            'Carts.status NOT IN' => [
                Cart::CART_STATUS_MERGED,
                Cart::CART_STATUS_REJECT,
                //Cart::CART_STATUS_OPEN,
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
                'status',
                'modified',
            ],
        ]);

        $this->set(compact('carts'));
    }
}
