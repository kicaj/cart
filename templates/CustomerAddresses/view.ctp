<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $customerAddress
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer Address'), ['action' => 'edit', $customerAddress->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer Address'), ['action' => 'delete', $customerAddress->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerAddress->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Address'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customerAddresses view large-9 medium-8 columns content">
    <h3><?= h($customerAddress->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cart') ?></th>
            <td><?= $customerAddress->has('cart') ? $this->Html->link($customerAddress->cart->id, ['controller' => 'Carts', 'action' => 'view', $customerAddress->cart->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Street') ?></th>
            <td><?= h($customerAddress->street) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($customerAddress->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerAddress->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Postal') ?></th>
            <td><?= $this->Number->format($customerAddress->postal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= $this->Number->format($customerAddress->country) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($customerAddress->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($customerAddress->modified) ?></td>
        </tr>
    </table>
</div>
