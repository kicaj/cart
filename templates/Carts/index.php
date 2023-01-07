<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
<div class="products index content">
    <h3><?= __d('cart', 'Cart') ?></h3>
    <?php if (!empty($cart->cart_items)): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><?= __d('cart', 'Item') ?></th>
                        <th><?= __d('cart', 'Price') ?></th>
                        <th><?= __d('cart', 'Tax') ?></th>
                        <th><?= __d('cart', 'Quantity') ?></th>
                        <th><?= __d('cart', 'Value') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart->cart_items as $cart_item): ?>
                        <tr>
                            <td>
                                <?= $cart_item->identifier; ?>
                            </td>
                            <td>
                                <?= $this->Number->currency($cart_item->price) ?>
                            </td>
                            <td>
                                <?php
                                    if (!is_null($cart_item->tax)) {
                                        echo $this->Number->toPercentage($cart_item->tax, 0);
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $this->cell('Cart.Cart::change', [
                                        $cart_item->identifier,
                                        $cart_item->quantity,
                                    ]);
                                ?>
                            </td>
                            <td>
                                <?= $this->Number->currency($cart_item->quantity * $cart_item->price) ?>
                            </td>
                            <td class="actions">
                                <?= $this->cell('Cart.Cart::remove', [
                                    $cart_item->identifier,
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br />
        <table>
            <tr>
                <td><?= __d('cart', 'Subtotal') ?>:</td>
                <td>
                    <?= $this->Number->currency($cart->amount_netto) ?><br>
                    netto
                </td>
            </tr>
            <tr>
                <td><?= __d('cart', 'Tax value') ?>:</td>
                <td><?= $this->Number->currency($cart->amount - $cart->amount_netto) ?></td>
            </tr>
            <tr>
                <td><?= __d('cart', 'Amount') ?>:</td>
                <td>
                    <?= $this->Number->currency($cart->amount) ?><br>
                    brutto
                </td>
            </tr>
        </table>
        <br>
        <div>
            <?= $this->Form->create($cart) ?>
                <?php
                    if (!$deliveries) {
                        echo __d('cart', 'Delivery');

                        echo $this->Form->radio('delivery_id', array_map(function ($delivery) {
                            return [
                                'value' => $delivery->id,
                                'text' => $delivery->name . ' (' . $this->Number->currency($delivery->cost) . ')',
                            ];
                        }, $deliveries->toArray()));
                    }

                    echo $this->Form->submit(__d('cart', 'Checkout'));
                ?>
            <?= $this->Form->end() ?>
        </div>
    <?php else: ?>
        <?= __d('cart', 'Cart is empty.') ?>
    <?php endif; ?>
</div>
