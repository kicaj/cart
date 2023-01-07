<?php
use Migrations\AbstractMigration;

class AddItemsToCarts extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cart_carts')
            ->addColumn('items', 'integer', [
                'signed' => false,
                'default' => 0,
                'limit' => 11,
                'null' => false,
                'after' => 'user_id',
            ])
            ->update();
    }
}
