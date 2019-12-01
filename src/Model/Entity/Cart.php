<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

class Cart extends Entity
{

    /**
     * Cart statuses.
     */
    public const CART_STATUS_MERGED = -2;
    public const CART_STATUS_REJECT = -1;
    public const CART_STATUS_OPEN = 0;
    public const CART_STATUS_NEW = 1;
    public const CART_STATUS_PENDING = 2;
    public const CART_STATUS_COMPLET = 3;

    /**
     * List of statuses.
     *
     * @return array List of statuses.
     */
    public static function getStatuses()
    {
        return [
            self::CART_STATUS_MERGED => __d('cart', 'Merged'),
            self::CART_STATUS_REJECT => __d('cart', 'Rejected'),
            self::CART_STATUS_OPEN => __d('cart', 'Open'),
            self::CART_STATUS_NEW => __d('cart', 'New'),
            self::CART_STATUS_PENDING => __d('cart', 'Pending'),
            self::CART_STATUS_COMPLET => __d('cart', 'Completed'),
        ];
    }

    /**
     * Get status.
     *
     * @param integer $status Status identifier.
     * @return string Status.
     */
    public static function getStatus($status)
    {
        if (array_key_exists($status, self::getStatuses())) {
            return self::getStatuses()[$status];
        }
    }
}
