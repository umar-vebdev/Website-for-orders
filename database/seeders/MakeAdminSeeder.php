<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class MakeAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(1);
        if ($user) {
            $user->role = 'admin';
            $user->save();
        }
    }
}
