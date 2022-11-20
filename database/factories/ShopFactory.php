<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $itemToDB = [];
        $items = [
            ['Телевизор Horizont 32LE7051D', 'Horizont', 'te/hz/Телевизор Horizont 32LE7051D.jpeg'],
            ['Телевизор LG 32LM576BPLD', 'LG', 'te/lg/Телевизор LG 32LM576BPLD.jpeg'],
            ['Телевизор Philips 43PFS5505(60)', 'Philips', 'te/ph/Телевизор Philips 43PFS5505.jpeg'],
            ['Ноутбук HP 250 G8 (2X7T8EA)', 'HP', 'no/hp/Ноутбук HP 250 G8 (2X7T8EA).jpg'],
            ['Ноутбук Lenovo IdeaPad L3 15ITL6', 'Lenovo', 'no/le/Ноутбук Lenovo IdeaPad L3 15ITL6.jpg'],
            ['Ноутбук Acer Aspire 3 A315-34-P7TD', 'Acer', 'no/ac/Ноутбук Acer Aspire 3 A315-34-P7TD.jpg'],
            ['Смартфон Apple iPhone 13 128GB', 'Apple', 'sm/ap/Смартфон Apple iPhone 13 128GB.jpg'],
            ['Смартфон Xiaomi Redmi Note 11 4GB(64GB)', 'Xiaomi', 'sm/xi/Смартфон Xiaomi Redmi Note 11 4GB.jpg'],
            ['Смартфон Samsung Galaxy A23 128GB', 'Samsung', 'sm/sa/Смартфон Samsung Galaxy A23 128GB.jpg'],
            ['Холодильник с морозильником ATLANT ХМ 4208-000', 'ATLANT', 'xo/at/Холодильник с морозильником ATLANT ХМ 4208-000.jpg'],
            ['Холодильник с морозильником LG DoorCooling GA-B509MMQM', 'LG', 'xo/lg/Холодильник с морозильником LG DoorCooling GA-B509MMQM.jpg'],
            ['Холодильник с морозильником Beko CNMV5335E20VS', 'Beko', 'xo/be/Холодильник с морозильником Beko CNMV5335E20VS.jpg'],
        ];
        $some = fake()->randomElement($items);
        $itemToDB = [
            'itemName' => $some[0],
            'manufacturer' => $some[1],
            'itemCost' => fake()->numberBetween(300, 2000),
            'itemImage' => $some[2],
            'created_year' => fake()->numberBetween(2013, 2022),
            'warrantyPeriod' => fake()->randomElement([null, '1 year', '2 year', '3 year']),
            'deliveryPeriod' => fake()->randomElement([null, '1 week', '8 days', '9 days', '10 days', '15 days']),
            'itemSetupCost' => fake()->numberBetween(10, 100),
        ];
        if (isset($itemToDB['warrantyPeriod'])) {
            $itemToDB['warrantyCost'] = fake()->numberBetween(100, 300);
        }
        if (isset($itemToDB['deliveryPeriod'])) {
            $itemToDB['deliveryCost'] = fake()->numberBetween(20, 100);
        }

        return $itemToDB;
    }
}
