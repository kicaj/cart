<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $delivery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('cart', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('cart', 'List Deliveries'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="deliveries form large-9 medium-8 columns content">
    <?= $this->Form->create($delivery) ?>
    <fieldset>
        <legend><?= __d('cart', 'Add Delivery') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('content');
            echo $this->Form->control('tax');
            echo $this->Form->control('cost');
        ?>
    </fieldset>
    <?= $this->Form->button(__d('cart', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
