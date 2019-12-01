<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            <?php use Cart\Model\Entity\Cart;

echo __d('cart', 'Carts'); ?>
        </h1>
    </div>
    <div class="card">
        <div class="card-header">
            <?php echo __d('cart', 'List'); ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-outline table-vcenter card-table">
                <thead>
                    <tr>
                        <th class="text-center w-1"><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                        <th><?php echo __d('cart', 'User'); ?></th>
                        <th class="text-center"><?php echo $this->Paginator->sort('items', __d('cart', 'Items')); ?></th>
                        <th class="text-right"><?php echo __d('cart', 'Amount'); ?></th>
                        <th class="text-center"><?php echo $this->Paginator->sort('status', __d('cart', 'status')); ?></th>
                        <th class="text-center"><?php echo $this->Paginator->sort('modified', __d('cart', 'Last modified')); ?></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carts as $cart): ?>
                        <tr>
                            <td class="text-center w-1">
                                <?php echo $cart->id; ?>
                            </td>
                            <td>
                                <div>
<?php if (!is_null($cart->user_id)): ?>
                                    <?php echo $cart->user_id; ?>
<?php else: ?>
                                    <?php echo __d('cart', 'Anonymous'); ?>
<?php endif; ?>
                                </div>
                                <div class="text-muted small">
                                    <?php echo __d('cart', 'Created at'); ?> <?php echo $cart->created; ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php echo $cart->items; ?>
                            </td>
                            <td class="text-right">
                                <?php echo $this->Number->currency($cart->amount); ?>
                            </td>
                            <td class="text-center">
                                <?php echo Cart::getStatus($cart->status); ?>
                            </td>
                            <td class="text-center">
                                <?php echo $cart->modified; ?>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <div data-toggle="dropdown" class="icon">
                                        <i class="fe fe-more-vertical"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                        <?php
                                            echo $this->Icon->link('eye dropdown-icon', __d('cart', 'View'), [
                                                'controller' => 'Carts',
                                                'action' => 'view',
                                                $cart->id,
                                            ], [
                                                'class' => 'dropdown-item',
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <?php echo $this->element('pagination'); ?>
            </div>
        </div>
    </div>
</div>
