<?php
use Cart\Model\Entity\Cart;
?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            <?php echo __d('admin', 'Carts'); ?>
        </h1>
    </div>
    <div class="card">
        <div class="card-header">
            <?php echo __d('admin', 'View'); ?>
            <div class="card-options">
                <span class="small">
                    <?php echo __d('admin', 'Last modified at'); ?> <?php echo $cart->modified; ?>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-label">
                    <?php echo __d('admin', 'Customer'); ?>
                </div>
                <div class="form-control-plaintext">
                    <?php if (!is_null($cart->customer_id)): ?>
                        <?php echo $cart->customer_id; ?>
                    <?php else: ?>
                        <span class="text-muted"><?php echo __d('cart', 'Anonymous'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <?php echo __d('admin', 'Amount'); ?>
                </div>
                <div class="form-control-plaintext">
                    <?php echo $this->Number->currency($cart->amount); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <?php echo __d('admin', 'Status'); ?>
                </div>
                <div class="form-control-plaintext">
                    <?php echo Cart::getStatus($cart->status); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <?php echo __d('admin', 'Items'); ?>
        </div>
        <?php if ($cartItems->isEmpty()): ?>
            <div class="card-body">
                <div class="text-center text-muted">
                    <i class="fe fe-alert-circle h1"></i><br>
                    <?php echo __d('admin', 'There is nothing to display.'); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-outline table-vcenter card-table">
                    <thead>
                        <tr>
                            <th class="text-center w-1"><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                            <th><?php echo __d('admin', 'Identifier'); ?></th>
                            <th class="text-center"><?php echo $this->Paginator->sort('price', __d('admin', 'Price')); ?></th>
                            <th class="text-center"><?php echo $this->Paginator->sort('tax', __d('admin', 'Tax')); ?></th>
                            <th class="text-center"><?php echo $this->Paginator->sort('quantity', __d('admin', 'Quantity')); ?></th>
                            <th class="text-center"><?php echo $this->Paginator->sort('modified', __d('admin', 'Last modified')); ?></th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $cartItem): ?>
                            <tr>
                                <td class="text-center w-1">
                                    <?php echo $cartItem->id; ?>
                                </td>
                                <td>
                                    <?php echo $cartItem->identifier; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $this->Number->currency($cartItem->price); ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                        if (!is_null($cartItem->tax)) {
                                            echo $this->Number->toPercentage($cartItem->tax, 0);
                                        }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $cartItem->quantity; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $cartItem->modified; ?>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <div data-toggle="dropdown" class="icon">
                                            <i class="fe fe-more-vertical"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                            <?php
                                                echo $this->Icon->postLink('x dropdown-icon text-danger', __d('admin', 'Remove'), [
                                                    'controller' => 'Carts',
                                                    'action' => 'item_delete',
                                                    $cartItem->id,
                                                ], [
                                                    'class' => 'dropdown-item text-danger',
                                                    'confirm' => __d('admin', 'Are you sure you want to do this?'),
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
        <?php endif; ?>
        <div class="card-footer">
            <div class="text-right">
                <?php echo $this->element('pagination'); ?>
            </div>
        </div>
    </div>
</div>
