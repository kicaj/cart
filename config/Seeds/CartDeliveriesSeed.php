<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * CartDeliveries seed.
 */
class CartDeliveriesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '',
                'content' => '',
                'tax' => 23,
                'cost' => '100.19',
            ],
            [
                'name' => 'DPD',
                'content' => 'Dynamic Parcel Distribution',
                'tax' => 8,
                'cost' => '13.50',
            ],
            [
                'name' => 'UPS',
                'content' => 'United Parcel Service',
                'tax' => 7,
                'cost' => '11.11',
            ],
        ];

        $this->table('cart_deliveries')
            ->insert($data)
            ->save();
    }
}
