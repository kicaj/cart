<?php
namespace Cart\Exception;

use Cake\Core\Exception\Exception;

class AmountNettoItemsException extends Exception
{

    /**
     * {@inheritdoc}
     */
    public function __construct($message = 'You are required to contain CartItems.', $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
