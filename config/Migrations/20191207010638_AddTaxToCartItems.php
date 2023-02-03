<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class AddTaxToCartItems extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_cart_items')
            ->addColumn('tax', Column::INTEGER, [
                'signed' => false,
                'default' => null,
                'limit' => 2,
                'null' => true,
                'after' => 'price',
            ])
            ->update();
    }
}
