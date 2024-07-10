<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessCode;

class AccessCodeSeeder extends Seeder
{
    public function run()
    {
        AccessCode::create(['code' => '123']);  // Replace 'YOUR_ACCESS_CODE' with the actual access code
    }
}
