<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * Delivery Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int|null $tax
 * @property float $cost
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property \Cart\Model\Entity\Cart $cart
 */
class Delivery extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'content' => true,
        'tax' => true,
        'cost' => true,
        'created_at' => true,
        'updated_at' => true,
    ];
}
