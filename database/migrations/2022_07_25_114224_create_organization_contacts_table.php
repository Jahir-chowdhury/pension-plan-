<?php

use App\Models\OrganizationContact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new OrganizationContact())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->string('designation')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
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
        Schema::dropIfExists('gpp_organization_contacts');
    }
}
