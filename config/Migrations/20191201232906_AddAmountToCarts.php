<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class AddAmountToCarts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_carts')
            ->addColumn('amount', Column::DECIMAL, [
                'signed' => false,
                'default' => 0,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'after' => 'items',
            ])
            ->update();
    }
}
