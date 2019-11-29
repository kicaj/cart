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
    public const CART_STATUS_PENDING = 1;
    public const CART_STATUS_COMPLET = 2;
}