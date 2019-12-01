<?php
use Migrations\AbstractMigration;

class AddItemsToCarts extends AbstractMigration
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
        $table->addColumn('items', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
            'after' => 'user_id',
        ]);
        $table->update();
    }
}
