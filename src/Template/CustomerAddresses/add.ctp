<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $customerAddress
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customerAddresses form large-9 medium-8 columns content">
    <?= $this->Form->create($customerAddress) ?>
    <fieldset>
        <legend><?= __('Add Customer Address') ?></legend>
        <?php
            echo $this->Form->control('cart_id', ['options' => $carts]);
            echo $this->Form->control('street');
            echo $this->Form->control('postal');
            echo $this->Form->control('city');
            echo $this->Form->control('country');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
