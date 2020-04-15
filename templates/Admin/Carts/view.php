<?php
use Cart\Model\Entity\Cart;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('cart', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('cart', 'List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="cart view large-9 medium-8 columns content">
    <h3><?= h($cart->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('cart', 'Customer') ?></th>
            <td><?= $cart->customer_id ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('cart', 'Status') ?></th>
            <td><?= Cart::getStatus($cart->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('cart', 'Payment') ?></th>
            <td><?= Cart::getPaymentStatus($cart->payment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('cart', 'Amount') ?></th>
            <td>
                <?= $this->Number->currency($cart->amount_netto) ?> netto<br>
                <?= $this->Number->currency($cart->amount - $cart->amount_netto) ?> <?= __d('cart', 'Tax value') ?><br>
                <?= $this->Number->currency($cart->amount); ?> brutto
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __d('cart', 'Total') ?></th>
            <td><?= $this->Number->currency($cart->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('cart', 'Created') ?></th>
            <td><?= h($cart->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('cart', 'Modified') ?></th>
            <td><?= h($cart->modified) ?></td>
        </tr>
    </table>
    <?php if (!empty($cart_items)): ?>
        <div class="related">
            <h4><?= __d('cart', 'Items') ?></h4>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('identifier') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('tax') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                    <th scope="col" class="actions"><?= __d('cart', 'Actions') ?></th>
                </tr>
                <?php foreach ($cart_items as $cart_item): ?>
                    <tr>
                        <td><?= $cart_item->identifier ?></td>
                        <td><?= $this->Number->currency($cart_item->price) ?></td>
                        <td><?= !is_null($cart_item->tax) ? $this->Number->toPercentage($cart_item->tax, 0) : '' ?></td>
                        <td><?= $cart_item->quantity ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__d('cart', 'Remove'), ['controller' => 'Carts', 'action' => 'removeItem', $cart_item->id], ['confirm' => __d('cart', 'Are you sure you want to remove # {0}?', $cart_item->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
    <?php if (!empty($cart->delivery)): ?>
        <div class="related">
            <h4><?= __d('cart', 'Delivery') ?></h4>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('cost') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('tax') ?></th>
                </tr>
                <tr>
                    <td><?= $cart->delivery->name ?></td>
                    <td><?= $this->Number->currency($cart->delivery->cost) ?></td>
                    <td><?= !is_null($cart->delivery->tax) ? $this->Number->toPercentage($cart->delivery->tax, 0) : '' ?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    <?php if (!empty($cart->customer_address)): ?>
        <div class="related">
            <h4><?= __d('cart', 'Customer Address') ?></h4>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('street') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('postal') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('country') ?></th>
                </tr>
                <tr>
                    <td><?= $cart->customer_address->street ?></td>
                    <td><?= $cart->customer_address->postal ?></td>
                    <td><?= $cart->customer_address->city ?></td>
                    <td><?= $cart->customer_address->country ?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>
