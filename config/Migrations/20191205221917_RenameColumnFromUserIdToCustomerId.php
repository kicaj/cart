<?php
use Migrations\AbstractMigration;

class RenameColumnFromUserIdToCustomerId extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_carts')
            ->renameColumn('user_id', 'customer_id')
            ->update();
    }
}
