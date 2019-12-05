<?php
    echo $this->Html->link(__d('cart', 'Cart summary') . ': ' . $this->Number->currency($cart->amount), [
        'prefix' => false,
        'plugin' => 'Cart',
        'controller' => 'Carts',
        'action' => 'index',
    ]);
?>