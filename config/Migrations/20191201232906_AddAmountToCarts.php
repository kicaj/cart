<?php
use Migrations\AbstractMigration;

class AddAmountToCarts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_carts')
            ->addColumn('amount', 'decimal', [
                'signed' => false,
                'default' => 0,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'after' => 'items',
            ])
            ->update();
    }
}
