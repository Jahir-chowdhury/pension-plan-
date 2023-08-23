<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(with(new User())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('staff_id')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->dateTime('password_updated_at')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('created_by_id')->nullable();
            $table->bigInteger('updated_by_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
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
