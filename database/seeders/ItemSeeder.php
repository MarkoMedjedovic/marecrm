<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'name' => 'Cash loan - prototype',
                'type' => 'cash',
                'loan_amount' => 1,
                'property_value' => 0,
                'down_payment' => 0,
                'memo' => 'loan note',
                'price' => 1,
                'customer_id' => 0,
                'user_id' => 0
            ],
            [
                'name' => 'Home loan - prototype',
                'type' => 'home',
                'loan_amount' => 0,
                'property_value' => 3,
                'down_payment' => 1,
                'memo' => 'loan note',
                'price' => 2,
                'customer_id' => 0,
                'user_id' => 0
            ]
        ]);
    }
}
            /*$table->string('type')->default("cash");
            $table->integer('loan_amount');
            $table->integer('property_value');
            $table->integer('down_payment');*/