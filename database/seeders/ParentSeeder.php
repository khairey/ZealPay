<?php

namespace Database\Seeders;

use App\Models\Parent_;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parent_::firstOrCreate([
            'name' => 'parent 1',  
        ]);
    }
}
