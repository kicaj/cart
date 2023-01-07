<?php
/**
 * @var \App\View\AppView $this
 * @var string $title
 * @var array $url
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
        'value' => 1,
    ]) ?>
    <?= $this->Form->submit($title, $options) ?>
<?= $this->Form->end() ?>
