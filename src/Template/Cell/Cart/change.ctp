<?php
    echo $this->Form->create('', [
        'url' => $link,
    ]);
?>
    <?php
        echo $this->Form->control('quantity', [
            'label' => __d('cart', 'Quantity'),
            'type' => 'number',
            'min' => 1,
            'value' => $quantity,
        ]);

        echo $this->Form->submit($label, $options);
    ?>
<?php echo $this->Form->end(); ?>
