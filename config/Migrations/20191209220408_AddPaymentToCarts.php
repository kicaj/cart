<?php
use Migrations\AbstractMigration;

class AddPaymentToCarts extends AbstractMigration
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
        $table = $this->table('carts');
        $table->addColumn('payment', 'integer', [
            'default' => null,
            'limit' => 1,
            'null' => true,
            'after' => 'status',
        ]);
        $table->update();
    }
}
