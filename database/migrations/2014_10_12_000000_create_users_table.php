<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary()->index();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->enum('user_type', ['SuperAdmin', 'Admin', 'User'])->default('User')->index();
            $table->rememberToken();
            $table->tinyInteger('status')->default(1)->index()->comment = "0-InActive, 1-Active";
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert user
        DB::table('users')->insert(
            array(
                'user_id' => Str::user_id(),
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'user_type' => 'SuperAdmin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'status' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
