<?php
use Migrations\AbstractMigration;

class AddDeliveryIdColumnToCarts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('carts')
            ->addColumn('cart_delivery_id', 'integer', [
                'after' => 'customer_id',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex(
                [
                    'cart_delivery_id',
                ]
            )
            ->addForeignKey(
                'cart_delivery_id',
                'deliveries',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }
}
