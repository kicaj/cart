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
        $carts = $this->paginate($this->Carts->find()->where([
            'Carts.status NOT IN' => [
                Cart::CART_STATUS_MERGED,
                Cart::CART_STATUS_REJECT,
                Cart::CART_STATUS_OPEN,
            ],
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
