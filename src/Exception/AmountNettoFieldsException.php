<?php
namespace Cart\Exception;

use Cake\Core\Exception\Exception;

class AmountNettoFieldsException extends Exception
{

    /**
     * {@inheritdoc}
     */
    public function __construct($message = 'You are required to select the price, tax and quantity fields.', $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
