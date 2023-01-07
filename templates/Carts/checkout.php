<div class="products index content">
    <h3><?= __d('cart', 'Checkout') ?></h3>
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
                            <?= $cart_item->quantity ?>
                        </td>
                        <td>
                            <?= $this->Number->currency($cart_item->quantity * $cart_item->price) ?>
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
            <tr>
                <td>
                    <?php echo __d('cart', 'Delivery cost'); ?>:<br>
                    <?php
                        if (!is_null($cart->delivery)) {
                            echo $cart->delivery->name;
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if (!is_null($cart->delivery)) {
                            echo $this->Number->currency($cart->delivery->cost);
                        } else {
                            echo $this->Number->currency(0);
                        }
                    ?><br>
                    brutto
                </td>
            </tr>
            <tr>
                <td><?php echo __d('cart', 'Total'); ?>:</td>
                <td>
                    <b><?php echo $this->Number->currency($cart->total); ?></b><br>
                    brutto
                </td>
            </tr>
        </table>
    <?php endif; ?>
</div>


<?php echo $this->Form->create($cart); ?>
    <fieldset>
        <legend><?= __('Add Customer Address') ?></legend>
        <?php
            echo $this->Form->control('customer_address.street');
            echo $this->Form->control('customer_address.postal');
            echo $this->Form->control('customer_address.city');
            echo $this->Form->control('customer_address.country');
        ?>
    </fieldset>
    <?php echo $this->Form->submit(__d('cart', 'Payment')); ?>
<?php echo $this->Form->end(); ?>
