<?php
use Migrations\AbstractMigration;

class AddPaymentToCarts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_carts')
            ->addColumn('payment', 'integer', [
                'signed' => false,
                'default' => null,
                'limit' => 1,
                'null' => true,
                'after' => 'status',
            ])
            ->update();
    }
}
