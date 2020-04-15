<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $deliveries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('cart', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('cart', 'New Delivery'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="deliveries index large-9 medium-8 columns content">
    <h3><?= __d('cart', 'Deliveries') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cost') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('cart', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveries as $delivery): ?>
            <tr>
                <td><?= $this->Number->format($delivery->id) ?></td>
                <td><?= h($delivery->name) ?></td>
                <td>
                	<?php
                		if (!is_null($delivery->tax)) {
                			echo $this->Number->toPercentage($delivery->tax);
                		}
                	?>
                </td>
                <td><?= $this->Number->currency($delivery->cost) ?></td>
                <td><?= h($delivery->created) ?></td>
                <td><?= h($delivery->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('cart', 'Edit'), ['action' => 'edit', $delivery->id]) ?>
                    <?= $this->Form->postLink(__d('cart', 'Delete'), ['action' => 'delete', $delivery->id], ['confirm' => __d('cart', 'Are you sure you want to delete # {0}?', $delivery->id)]) ?>
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
        <p><?= $this->Paginator->counter(__d('cart', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
