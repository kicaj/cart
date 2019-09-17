<?php
    echo $this->Html->link(__d('cart', 'Cart summary') . ': ' . $this->Number->currency($summary), [
        'prefix' => false,
        'plugin' => 'Cart',
        'controller' => 'Carts',
        'action' => 'index',
    ]);
?>