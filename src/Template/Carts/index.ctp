<?php if (!empty($cart->cart_items)): ?>
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
                    <?php
                        echo $this->cell('Cart.Cart::change', [
                            $cart_item->identifier,
                            $cart_item->quantity,
                        ]);
                    ?>
                </td>
                <td>
                    <?php echo $this->Number->currency($cart_item->quantity * $cart_item->price); ?>
                </td>
                <td>
                    <?php
                        echo $this->cell('Cart.Cart::remove', [
                            $cart_item->identifier,
                        ]);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <?php echo __d('cart', 'Cart is empty.'); ?>
<?php endif; ?>
