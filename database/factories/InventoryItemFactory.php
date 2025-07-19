<?php


namespace Database\Factories;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryItemFactory extends Factory
{
    protected $model = InventoryItem::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-#####')),
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
