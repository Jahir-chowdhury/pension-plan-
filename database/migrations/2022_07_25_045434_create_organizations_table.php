<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Organization;
class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new Organization)->getTable()), function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique()->comment('Unique Organization code');
            $table->string('name', 150)->unique()->comment('Organization unique Name');
            $table->unsignedTinyInteger('claim_payable_to')->default(2)->comment('1: Client 2: Organization');
            $table->string('phone', 20)->unique();
            $table->string('email', 100)->unique();
            $table->date('contract_date')->comment('When The contract made')->nullable();
            $table->date('commencement_date')->nullable();
            $table->float('profit_commision')->default(6);
            $table->float('employer_protion')->default(5);
            $table->float('employee_protion')->default(5);
            $table->unsignedInteger('management_expenses')->default(600);
            $table->string('sold_by')->nullable()->comment('Who sold to this organization');
            $table->string('sold_as')->nullable()->comment('Designation when the employee sold this');
            $table->string('marketed_by')->nullable()->comment('Who marketed for seeling this');
            $table->string('bank_name')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('bank_branch_routing_number', 50)->nullable();
            $table->string('bank_account_number', 70)->unique()->nullable();
            $table->string('bank_account_name', 150)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('address', 400)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
