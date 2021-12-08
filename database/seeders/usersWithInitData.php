<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;

class usersWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app(CreateNewUser::class)->create([
            'id'         => 1,
            'name'       => 'John Doe',
            'email'      => 'john_doe@site.com',
            'password'   => '11111111',
            'status'     => 'A',
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ], true, [PERMISSION_APP_ADMIN, PERMISSION_CUSTOMER]);
    }
}
