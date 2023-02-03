<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateCustomerAddresses extends AbstractMigration
{
    public function change(): void
    {
        $this->table('customer_addresses', ['signed' => false])
            ->addColumn('cart_cart_id', Column::INTEGER, [
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('street', Column::STRING, [
                'null' => false,
            ])
            ->addColumn('postal', Column::INTEGER, [
                'limit' => 6,
                'null' => false,
            ])
            ->addColumn('city', Column::STRING, [
                'null' => false,
            ])
            ->addColumn('country', Column::INTEGER, [
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
