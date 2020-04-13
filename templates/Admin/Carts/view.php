<?php
use Cart\Model\Entity\Cart;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="cart view large-9 medium-8 columns content">
    <h3><?= h($cart->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= Cart::getStatus($cart->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= Cart::getPaymentStatus($cart->payment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->currency($cart->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cart->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cart->modified) ?></td>
        </tr>
    </table>
    <?php if (!empty($cart_items)): ?>
        <div class="related">
            <h4><?= __('Items') ?></h4>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('identifier') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('tax') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($cart_items as $cart_item): ?>
                    <tr>
                        <td><?= $cart_item->identifier ?></td>
                        <td><?= $this->Number->currency($cart_item->price) ?></td>
                        <td><?= !is_null($cart_item->tax) ? $this->Number->toPercentage($cart_item->tax, 0) : '' ?></td>
                        <td><?= $cart_item->quantity ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Carts', 'action' => 'deleteItem', $cart_item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart_item->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
    <?php if (!empty($cart->delivery)): ?>
        <div class="related">
            <h4><?= __('Delivery') ?></h4>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('cost') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('tax') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <tr>
                    <td><?= $cart->delivery->name ?></td>
                    <td><?= $this->Number->currency($cart->delivery->cost) ?></td>
                    <td><?= !is_null($cart->delivery->tax) ? $this->Number->toPercentage($cart->delivery->tax, 0) : '' ?></td>
                    <td class="actions">

                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    <?php if (!empty($cart->customer_address)): ?>
        <div class="related">
            <h4><?= __('Customer Address') ?></h4>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('street') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('postal') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('country') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <tr>
                    <td><?= $cart->customer_address->street ?></td>
                    <td><?= $cart->customer_address->postal ?></td>
                    <td><?= $cart->customer_address->city ?></td>
                    <td><?= $cart->customer_address->country ?></td>
                    <td class="actions">

                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>
