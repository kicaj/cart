<?php
use Migrations\AbstractMigration;

class CreateCustomerAddresses extends AbstractMigration
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
        $table = $this->table('customer_addresses');
        $table->addColumn('cart_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('street', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('postal', 'integer', [
            'limit' => 6,
            'null' => false,
        ]);
        $table->addColumn('city', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('country', 'integer', [
            'limit' => 3,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'limit' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'limit' => null,
            'null' => false,
        ]);
        $table->addIndex(
            [
                'cart_id',
            ]
        );
        $table->addForeignKey(
            'cart_id',
            'carts',
            'id',
            [
                'update' => 'CASCADE',
                'delete' => 'CASCADE'
            ]
        );
        $table->create();
    }
}
