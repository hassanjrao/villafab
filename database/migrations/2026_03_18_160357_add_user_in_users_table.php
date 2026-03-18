<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class AddUserInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'name' => 'Admin Alex',
            'email' => 'AlexLluch3@gmail.com',
            'password' => bcrypt('Villafabulosa963'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
