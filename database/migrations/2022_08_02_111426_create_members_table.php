<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Member;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create( with(new Member())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->comment('Employee ID');
            $table->string('member_id');
            $table->string('nominee_id')->nullable();
            $table->string('name');
            $table->string('department', 100);
            $table->string('designation', 100);
            $table->date('date_of_birth');
            $table->integer('onboard_age');
            $table->string('sex', 10);
            $table->string('maritial_status', 10);
            $table->unsignedInteger('salary');
            $table->unsignedInteger('fix_salary')->nullable();
            $table->date('membership_date');
            $table->boolean('is_active');
            $table->float('policy_fix_charge');
            $table->float('admin_charge');
            $table->float('mortality_charge');
            $table->bigInteger('sum_at_risk');
            $table->float('employeeContribution');
            $table->float('employerContribution');
            $table->float('premium');
            $table->float('net_charge');
            $table->string('bank_name', 190);
            $table->string('bank_branch_name', 90);
            $table->string('bank_branch_routing_number', 50);
            $table->string('bank_account_number', 50);
            $table->string('mobile', 20);
            $table->string('email', 50);
            $table->string('org_id', 30);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('nid_number', 50)->nullable()->comment('National Identity card number');
            $table->string('file_emp_photo_name')->nullable()->comment('Employee photo file name');
            $table->string('file_nid_photo_name')->nullable()->comment('Employee NID card photo');
            $table->string('file_emp_photo_path')->nullable()->comment('Employee photo file name');
            $table->string('file_nid_photo_path')->nullable()->comment('Employee NID card photo');
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
        Schema::dropIfExists(with(new Member())->getTable());
    }
}
