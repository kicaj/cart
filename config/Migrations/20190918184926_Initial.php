<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up(): void
    {
        $this->table('cart_cart_items')
            ->addColumn('cart_cart_id', 'integer', [
                'signed' => false,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('identifier', 'uuid', [
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'signed' => false,
                'default' => '0.00',
                'null' => false,
                'precision' => 8,
                'scale' => 2,
            ])
            ->addColumn('quantity', 'integer', [
                'signed' => false,
                'default' => '1',
                'null' => false,
            ])
            ->addTimestamps()
            ->addIndex('cart_cart_id')
            ->addIndex('identifier')
            ->create();

        $this->table('cart_carts')
            ->addColumn('session_id', 'string', [
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'signed' => false,
                'default' => null,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '0',
                'limit' => 1,
                'null' => false,
            ])
            ->addTimestamps()
            ->addIndex('session_id')
            ->addIndex('user_id')
            ->addIndex('status')
            ->create();

        $this->table('cart_cart_items')
            ->addForeignKey('cart_cart_id', 'cart_carts', 'id', [
                'update' => 'CASCADE',
                'delete' => 'CASCADE'
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('cart_cart_items')
            ->dropForeignKey('cart_cart_id')
            ->save();

        $this->table('cart_cart_items')
            ->drop()
            ->save();
        $this->table('cart_carts')
            ->drop()
            ->save();
    }
}
