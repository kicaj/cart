<?php
use Migrations\AbstractMigration;

class AddAmountToCarts extends AbstractMigration
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
        $table->addColumn('amount', 'decimal', [
            'default' => 0,
            'null' => false,
            'precision' => 10,
            'scale' => 2,
            'after' => 'items',
        ]);
        $table->update();
    }
}
