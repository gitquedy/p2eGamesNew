<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['eth_address' => '0x2789B765F53da04EFb3D65dED8996C4aef740C7d']);
    }
}
