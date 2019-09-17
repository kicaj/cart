<?php
    echo $this->Form->create('', [
        'url' => $link,
    ]);
?>
    <?php
        echo $this->Form->control('quantity', [
            'type' => 'number',
            'min' => 1,
            'value' => 1,
        ]);

        echo $this->Form->submit($label, $options);
    ?>
<?php echo $this->Form->end(); ?>
