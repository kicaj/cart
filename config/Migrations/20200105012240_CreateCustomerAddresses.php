<?php
use Migrations\AbstractMigration;

class CreateCustomerAddresses extends AbstractMigration
{
    public function change(): void
    {
        $this->table('customer_addresses')
            ->addColumn('cart_cart_id', 'integer', [
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('street', 'string', [
                'null' => false,
            ])
            ->addColumn('postal', 'integer', [
                'limit' => 6,
                'null' => false,
            ])
            ->addColumn('city', 'string', [
                'null' => false,
            ])
            ->addColumn('country', 'integer', [
                'limit' => 3,
                'null' => false,
            ])
            ->addTimestamps()
            ->addIndex( 'cart_cart_id')
            ->addForeignKey('cart_cart_id', 'cart_carts', 'id', [
                'delete' => 'CASCADE'
            ])
            ->create();
    }
}
