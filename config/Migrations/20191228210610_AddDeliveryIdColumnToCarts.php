<?php
use Migrations\AbstractMigration;

class AddDeliveryIdColumnToCarts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_carts')
            ->addColumn('delivery_id', 'integer', [
                'signed' => false,
                'after' => 'customer_id',
                'default' => null,
                'null' => true,
            ])
            ->addIndex('delivery_id')
            ->addForeignKey('delivery_id', 'deliveries', 'id', [
                'delete' => 'SET NULL'
            ])
            ->update();
    }
}
