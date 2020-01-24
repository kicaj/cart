<?php
    echo $this->Form->create(null, [
        'url' => $link,
    ]);
?>
    <?php
        echo $this->Form->control('quantity', [
            'label' => __d('cart', 'Quantity'),
            'type' => 'number',
            'min' => 1,
            'value' => 1,
        ]);

        echo $this->Form->submit($label, $options);
    ?>
<?php echo $this->Form->end(); ?>
