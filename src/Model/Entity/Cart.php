<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

class Cart extends Entity
{

    /**
     * Cart statuses.
     */
    public const CART_STATUS_MERGED = -2; // Technical
    public const CART_STATUS_REJECTED = -1;
    public const CART_STATUS_OPEN = 0; // Technical
    public const CART_STATUS_NEW = 1;
    public const CART_STATUS_PENDING = 2;
    public const CART_STATUS_COMPLETED = 3;
    public const CART_STATUS_SHIPPED = 3;
    public const CART_STATUS_REFUNDED = 5;
    public const CART_STATUS_COMPLAINED = 6;

    /**
     * List of statuses.
     *
     * @return array Statuses list.
     */
    public static function getStatuses()
    {
        return [
            self::CART_STATUS_MERGED => __d('cart', 'Merged'),
            self::CART_STATUS_REJECTED => __d('cart', 'Rejected'),
            self::CART_STATUS_OPEN => __d('cart', 'Open'),
            self::CART_STATUS_NEW => __d('cart', 'New'),
            self::CART_STATUS_PENDING => __d('cart', 'Pending'),
            self::CART_STATUS_COMPLETED => __d('cart', 'Completed'),
            self::CART_STATUS_SHIPPED => __d('cart', 'Shipped'),
            self::CART_STATUS_REFUNDED => __d('cart', 'Refunded'),
            self::CART_STATUS_COMPLAINED => __d('cart', 'Complained'),
        ];
    }

    /**
     * Get status.
     *
     * @param integer $status Status identifier.
     * @return string Status name.
     */
    public static function getStatus($status)
    {
        $statuses = self::getStatuses();

        if (array_key_exists($status, $statuses)) {
            return $statuses[$status];
        }

        return '';
    }
}
