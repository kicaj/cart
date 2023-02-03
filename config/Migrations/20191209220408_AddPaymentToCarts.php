<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class AddPaymentToCarts extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cart_carts')
            ->addColumn('payment', Column::INTEGER, [
                'signed' => false,
                'default' => null,
                'limit' => 1,
                'null' => true,
                'after' => 'status',
            ])
            ->update();
    }
}
