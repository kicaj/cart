<?php
/**
 * @var \App\View\AppView $this
 * @var string $title
 * @var array $url
 * @var array<string, mixed> $options
 */

if (!isset($button['class'])) {
    $options['class'] = 'button';
}
?>
<?= $this->Html->link($title, $url, $options) ?>
