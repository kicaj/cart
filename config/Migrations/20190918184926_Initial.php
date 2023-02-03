<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class Initial extends AbstractMigration
{
    public function up(): void
    {
        $this->table('cart_cart_items', ['signed' => false])
            ->addColumn('cart_cart_id', Column::INTEGER, [
                'signed' => false,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('identifier', Column::UUID, [
                'null' => false,
            ])
            ->addColumn('price', Column::DECIMAL, [
                'signed' => false,
                'default' => '0.00',
                'null' => false,
                'precision' => 8,
                'scale' => 2,
            ])
            ->addColumn('quantity', Column::INTEGER, [
                'signed' => false,
                'default' => '1',
                'null' => false,
            ])
            ->addTimestamps()
            ->addIndex('cart_cart_id')
            ->addIndex('identifier')
            ->create();

        $this->table('cart_carts', ['signed' => false])
            ->addColumn('session_id', Column::STRING, [
                'null' => false,
            ])
            ->addColumn('user_id', Column::INTEGER, [
                'signed' => false,
                'default' => null,
                'null' => true,
            ])
            ->addColumn('status', Column::INTEGER, [
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
