<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', '!=', 'admin')->get();

        foreach ($users as $user) {
            Trip::factory(2)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
