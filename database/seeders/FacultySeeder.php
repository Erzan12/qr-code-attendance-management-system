<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty = Faculty::factory()->create([
            'employee_id' => '123',
            'department' => 'CCSIT',
        ]);

        User::create([
            'username' => $faculty->employee_id,
            'password' => Hash::make('1234'),
            'user_id' => $faculty->id,
            'account_type' => 3,
        ]);
    }
}
