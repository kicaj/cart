<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerAddress Entity
 *
 * @property int $id
 * @property int $cart_id
 * @property string $street
 * @property int $postal
 * @property string $city
 * @property int $country
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Cart\Model\Entity\Cart $cart
 */
class CustomerAddress extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'cart_id' => true,
        'street' => true,
        'postal' => true,
        'city' => true,
        'country' => true,
        'created' => true,
        'modified' => true,
        'cart' => true,
    ];
}
