<?php
use Migrations\AbstractMigration;

class CreateDeliveries extends AbstractMigration
{
    public function change(): void
    {
        $this->table('deliveries')
            ->addColumn('name', 'string', [
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'null' => false,
            ])
            ->addColumn('tax', 'integer', [
                'signed' => false,
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('cost', 'decimal', [
                'signed' => false,
                'null' => false,
                'precision' => 6,
                'scale' => 2,
            ])
            ->addTimestamps()
            ->create();
    }
}
