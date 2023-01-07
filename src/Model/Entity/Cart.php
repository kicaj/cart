<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;
use Cart\Exception\AmountNettoFieldsException;
use Cart\Exception\AmountNettoItemsException;

/**
 * Cart Entity.
 *
 * @property int $id
 * @property string $session_id
 * @property int|null $customer_id
 * @property int|null $delivery_id
 * @property int $items
 * @property float $amount
 * @property int|null $payment
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property \Cart\Model\Entity\Delivery $delivery
 * @property \Cart\Model\Entity\CartItem[] $cart_items
 */
class Cart extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'session_id' => true,
        'customer_id' => true,
        'items' => true,
        'amount' => true,
        'cart_items' => true,
    ];

    /**
     * Cart statuses.
     */
    public const STATUS_MERGED = -2; // Technical
    public const STATUS_REJECTED = -1;
    public const STATUS_OPEN = 0; // Technical
    public const STATUS_NEW = 1;
    public const STATUS_READY = 2;
    public const STATUS_SHIPPED = 3;
    public const STATUS_REFUNDED = 4;
    public const STATUS_COMPLAINED = 5;

    /**
     * Cart payment statuses.
     */
    public const PAYMENT_CANCELED = -1;
    public const PAYMENT_STARTED = 0;
    public const PAYMENT_PENDING = 1;
    public const PAYMENT_COMPLETED = 2;
    public const PAYMENT_DELIVERY = 3;

    /**
     * List of statuses.
     *
     * @return array Statuses list.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_MERGED => __d('cart', 'Merged'),
            self::STATUS_REJECTED => __d('cart', 'Rejected'),
            self::STATUS_OPEN => __d('cart', 'Open'),
            self::STATUS_NEW => __d('cart', 'New'),
            self::STATUS_READY => __d('cart', 'Ready'),
            self::STATUS_SHIPPED => __d('cart', 'Shipped'),
            self::STATUS_REFUNDED => __d('cart', 'Refunded'),
            self::STATUS_COMPLAINED => __d('cart', 'Complained'),
        ];
    }

    /**
     * Get status.
     *
     * @param integer $status Status identifier.
     * @return string Status name.
     */
    public static function getStatus(int $status): string
    {
        $statuses = self::getStatuses();

        if (array_key_exists($status, $statuses)) {
            return $statuses[$status];
        }

        return '';
    }

    /**
     * List of payment statuses.
     *
     * @return array Payment statuses list.
     */
    public static function getPaymentStatuses(): array
    {
        return [
            self::PAYMENT_CANCELED => __d('cart', 'Canceled'),
            self::PAYMENT_STARTED => __d('cart', 'Started'),
            self::PAYMENT_PENDING => __d('cart', 'Pending'),
            self::PAYMENT_COMPLETED => __d('cart', 'Completed'),
            self::PAYMENT_DELIVERY => __d('cart', 'On delivery'),
        ];
    }

    /**
     * Get payment status.
     *
     * @param int $paymentStatus Payment identifier.
     * @return string Payment status name.
     */
    public static function getPaymentStatus(int $paymentStatus): string
    {
        $paymentStatuses = self::getPaymentStatuses();

        if (array_key_exists($paymentStatus, $paymentStatuses)) {
            return $paymentStatuses[$paymentStatus];
        }

        return '';
    }

    /**
     * Get items amount netto.
     *
     * @return float Amount netto value.
     */
    protected function _getAmountNetto(): float
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

    /**
     * Get total brutto.
     *
     * @return float Total brutto value.
     */
    protected function _getTotal(): float
    {
        $total = $this->amount;

        if (!is_null($this->delivery)) {
            $total += $this->delivery->cost;
        }

        return $total;
    }
}
