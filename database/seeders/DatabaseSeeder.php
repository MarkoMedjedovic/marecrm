<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
        ]);

        \App\Models\Customer::factory(200)->create();

        Purchase::factory(5)->create();
        $items = \App\Models\Item::all();
        Purchase::factory(5)->create()->each(function (Purchase $purchase) use ($items) {
            
            $max = count($items);
            $purchase->items()->attach(
                $items->random(rand(1, $max))->pluck('id')->toArray(),
                ['quantity' => 1]
            );
        });
    }
}
