<?php
use Cart\Model\Entity\Cart;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('cart', 'Actions') ?></li>
    </ul>
</nav>
<div class="carts index large-9 medium-8 columns content">
    <h3><?= __d('cart', 'Carts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('cart', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carts as $cart): ?>
            <tr>
                <td><?= $this->Number->format($cart->id) ?></td>
                <td><?= Cart::getStatus($cart->status) ?></td>
                <td><?= Cart::getPaymentStatus($cart->payment) ?></td>
                <td><?= $this->Number->currency($cart->total) ?></td>
                <td><?= h($cart->created) ?></td>
                <td><?= h($cart->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('cart', 'View'), ['action' => 'view', $cart->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __d('cart', 'first')) ?>
            <?= $this->Paginator->prev('< ' . __d('cart', 'previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__d('cart', 'next') . ' >') ?>
            <?= $this->Paginator->last(__d('cart', 'last') . ' >>') ?>
        </ul>
    </div>
</div>
