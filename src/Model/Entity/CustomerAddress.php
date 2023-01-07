<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerAddress Entity.
 *
 * @property int $id
 * @property int $cart_cart_id
 * @property string $street
 * @property int $postal
 * @property string $city
 * @property int $country
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property \Cart\Model\Entity\Cart $cart
 */
class CustomerAddress extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'street' => true,
        'postal' => true,
        'city' => true,
        'country' => true,
        'created_at' => true,
        'updated_at' => true,
        'cart' => true,
    ];
}
