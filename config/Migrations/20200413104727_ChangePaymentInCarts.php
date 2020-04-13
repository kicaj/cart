<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChangePaymentInCarts extends AbstractMigration
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
            ->changeColumn('payment', 'integer', [
                'limit' => 1,
                'default' => 0,
                'null' => false,
            ])
            ->addIndex( [
                'payment',
            ])
            ->update();
    }
}
