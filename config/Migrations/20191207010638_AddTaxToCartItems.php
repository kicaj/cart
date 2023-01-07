<?php
use Migrations\AbstractMigration;

class AddTaxToCartItems extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_cart_items')
            ->addColumn('tax', 'integer', [
                'signed' => false,
                'default' => null,
                'limit' => 2,
                'null' => true,
                'after' => 'price',
            ])
            ->update();
    }
}
