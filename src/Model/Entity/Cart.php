<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;
use Cart\Exception\AmountNettoFieldsException;
use Cart\Exception\AmountNettoItemsException;

class Cart extends Entity
{

    /**
     * Cart statuses.
     */
    public const CART_STATUS_MERGED = -2; // Technical
    public const CART_STATUS_REJECTED = -1;
    public const CART_STATUS_OPEN = 0; // Technical
    public const CART_STATUS_NEW = 1;
    public const CART_STATUS_READY = 2;
    public const CART_STATUS_SHIPPED = 3;
    public const CART_STATUS_REFUNDED = 4;
    public const CART_STATUS_COMPLAINED = 5;

    /**
     * Cart payments.
     */
    public const CART_PAYMENT_CANCELED = -1;
    public const CART_PAYMENT_STARTED = 0;
    public const CART_PAYMENT_PENDING = 1;
    public const CART_PAYMENT_COMPLETED = 2;
    public const CART_PAYMENT_DELIVERY = 3;

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
            self::CART_STATUS_READY => __d('cart', 'Ready'),
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

    /**
     * List of payments.
     *
     * @return array Payment list.
     */
    public static function getPayments()
    {
        return [
            self::CART_PAYMENT_CANCELED => __d('cart', 'Canceled'),
            self::CART_PAYMENT_STARTED => __d('cart', 'Started'),
            self::CART_PAYMENT_PENDING => __d('cart', 'Pending'),
            self::CART_PAYMENT_COMPLETED => __d('cart', 'Completed'),
            self::CART_PAYMENT_DELIVERY => __d('cart', 'On delivery'),
        ];
    }

    /**
     * Get payment.
     *
     * @param integer $payment Payment identifier.
     * @return string Payment name.
     */
    public static function getPayment($payment)
    {
        $payments = self::getPayments();

        if (array_key_exists($payment, $payments)) {
            return $payments[$payment];
        }

        return '';
    }

    /**
     * Get amount netto.
     *
     * @return float Amount netto value.
     */
    protected function _getAmountNetto()
    {
        if (isset($this->cart_items)) {
            $amount_netto = 0;

            foreach ($this->cart_items as $cart_item) {
                if (!isset($cart_item['price'], $cart_item['quantity']) || !array_key_exists('tax', $cart_item->toArray())) {
                    throw new AmountNettoFieldsException();
                }

                if (!is_null($cart_item->tax)) {
                    $amount_netto += ($cart_item->price / (($cart_item->tax / 100) + 1)) * $cart_item->quantity;
                } else {
                    $amount_netto += $cart_item->price * $cart_item->quantity;
                }
            }

            return round($amount_netto, 2);
        } else {
            throw new AmountNettoItemsException();
        }
    }
}
