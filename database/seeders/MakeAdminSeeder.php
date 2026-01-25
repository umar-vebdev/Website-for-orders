<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'maucher@gmail.com'],
            [
                'name' => 'Manucher',
                'password' => Hash::make('manucher0101'),
                'is_admin' => 1,
            ]
        );
    }
}
