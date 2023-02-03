<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class AddItemsToCarts extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cart_carts')
            ->addColumn('items', Column::INTEGER, [
                'signed' => false,
                'default' => 0,
                'limit' => 11,
                'null' => false,
                'after' => 'user_id',
            ])
            ->update();
    }
}
