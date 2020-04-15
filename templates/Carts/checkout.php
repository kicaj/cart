<table>
    <tr>
        <th><?php echo __d('cart', 'Item'); ?></th>
        <th><?php echo __d('cart', 'Price'); ?></th>
        <th><?php echo __d('cart', 'Tax'); ?></th>
        <th><?php echo __d('cart', 'Quantity'); ?></th>
        <th><?php echo __d('cart', 'Value'); ?></th>
        <th></th>
    </tr>
    <?php foreach ($cart->cart_items as $cart_item): ?>
        <tr>
            <td>
                <?php echo $cart_item->identifier; ?>
            </td>
            <td>
                <?php echo $this->Number->currency($cart_item->price); ?>
            </td>
            <td>
                <?php
                    if (!is_null($cart_item->tax)) {
                        echo $this->Number->toPercentage($cart_item->tax, 0);
                    }
                ?>
            </td>
            <td>
                <?php echo $cart_item->quantity; ?>
            </td>
            <td>
                <?php echo $this->Number->currency($cart_item->quantity * $cart_item->price); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<table>
    <caption><?php echo __d('cart', 'Summary'); ?></caption>
    <tr>
        <td><?php echo __d('cart', 'Subtotal'); ?>:</td>
        <td>
            <?php echo $this->Number->currency($cart->amount_netto); ?><br>
            netto
        </td>
    </tr>
    <tr>
        <td><?php echo __d('cart', 'Tax value'); ?>:</td>
        <td><?php echo $this->Number->currency($cart->amount - $cart->amount_netto); ?></td>
    </tr>
    <tr>
        <td><?php echo __d('cart', 'Amount'); ?>:</td>
        <td>
            <?php echo $this->Number->currency($cart->amount); ?><br>
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
