<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = Student::factory()->create([
            'id_number' => '123456-1',
            'department' => 'CCSIT',
        ]);

        \App\Models\User::create([
            'username' => $student->id_number,
            'password' => bcrypt('1234'),
            'user_id' => $student->id,
            'account_type' => 2,
        ]);
    }
}
