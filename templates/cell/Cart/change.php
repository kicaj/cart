<?php
/**
 * @var \App\View\AppView $this
 * @var array $url
 * @var int $quantity
 * @var string $caption
 * @var array<string, mixed> $options
 */
?>
<?= $this->Form->create(null, [
    'url' => $url,
]) ?>
    <?= $this->Form->control('quantity', [
        'label' => false,
        'type' => 'number',
        'min' => 1,
        'value' => $quantity,
    ]) ?>
    <?= $this->Form->submit($caption, $options) ?>
<?= $this->Form->end() ?>
