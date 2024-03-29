<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameDeliveries extends AbstractMigration
{
    public function change(): void
    {
        $this->table('deliveries')
            ->rename('cart_deliveries')
            ->update();
    }
}
