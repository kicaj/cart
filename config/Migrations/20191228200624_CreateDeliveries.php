<?php
use Migrations\AbstractMigration;

class CreateDeliveries extends AbstractMigration
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
        $table = $this->table('deliveries')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tax', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => true,
                'after' => 'price',
            ])
            ->addColumn('cost', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 6,
                'scale' => 2,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ]) 
            ->create();
    }
}
