<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'account_name' => 'Ralph Laurence Quito',
            'provider' => 'UnionBank',
            'account_number' => '1096 5549 1958',
            'isActive' => true,
            'icon' => 'ub.png'
        ]);

        PaymentMethod::create([
            'account_name' => 'Ralph Laurence Quito',
            'provider' => 'BDO',
            'account_number' => '001330695567',
            'isActive' => true,
            'icon' => 'bdo.png'
        ]);

        PaymentMethod::create([
            'account_name' => 'Ralph Laurence Quito',
            'provider' => 'GCASH',
            'account_number' => '09760247040',
            'isActive' => true,
            'icon' => 'gcash.png'
        ]);

        PaymentMethod::create([
            'account_name' => 'Ralph Laurence Quito',
            'provider' => 'Paymaya',
            'account_number' => '09453513307',
            'isActive' => true,
            'icon' => 'paymaya.png'
        ]);
    }
}
