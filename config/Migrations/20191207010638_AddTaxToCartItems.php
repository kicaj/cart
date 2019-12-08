<?php
use Migrations\AbstractMigration;

class AddTaxToCartItems extends AbstractMigration
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
        $table = $this->table('cart_items');
        $table->addColumn('tax', 'integer', [
            'default' => null,
            'limit' => 2,
            'null' => true,
            'after' => 'price',
        ]);
        $table->update();
    }
}
