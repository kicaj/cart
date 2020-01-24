<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $delivery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Delivery'), ['action' => 'edit', $delivery->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Delivery'), ['action' => 'delete', $delivery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $delivery->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Deliveries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="deliveries view large-9 medium-8 columns content">
    <h3><?= h($delivery->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($delivery->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax') ?></th>
            <td>
            	<?php
            		if (!is_null($delivery->tax)) {
            			echo $this->Number->toPercentage($delivery->tax);
            		}
            	?>            
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cost') ?></th>
            <td><?= $this->Number->currency($delivery->cost) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($delivery->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($delivery->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Content') ?></th>
            <td><?= h($delivery->content) ?></td>
        </tr>
    </table>
</div>
