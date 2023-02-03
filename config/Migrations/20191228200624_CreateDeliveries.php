<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateDeliveries extends AbstractMigration
{
    public function change(): void
    {
        $this->table('deliveries', ['signed' => false])
            ->addColumn('name', Column::STRING, [
                'null' => false,
            ])
            ->addColumn('content', Column::TEXT, [
                'null' => false,
            ])
            ->addColumn('tax', Column::INTEGER, [
                'signed' => false,
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('cost', Column::DECIMAL, [
                'signed' => false,
                'null' => false,
                'precision' => 6,
                'scale' => 2,
            ])
            ->addTimestamps()
            ->create();
    }
}
