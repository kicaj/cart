<?php
/**
 * @var \App\View\AppView $this
 * @var \Cart\Model\Entity\Cart $cart
 */
?>
<?= $this->Html->link(__d('cart', 'Cart summary') . ': ' . $this->Number->currency($cart->amount), [
    'prefix' => false,
    'plugin' => 'Cart',
    'controller' => 'Carts',
    'action' => 'index',
]) ?>
(<?= __d('cart', 'Items') ?>: <?= $cart->items ?>)
