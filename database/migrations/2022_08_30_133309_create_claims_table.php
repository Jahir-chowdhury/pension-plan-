<?php

use App\Models\Claim;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new Claim())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->string('organization_id')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('member_id', 20)->nullable();
            $table->string('intimation_number', 20)->nullable();
            $table->string('incident_remarks')->nullable();
            $table->enum('claim_type', App\Enums::CLAIM_TYPES)->nullable();
            $table->date('incident_date')->nullable();
            $table->double('claimed_amount')->nullable();
            $table->unsignedBigInteger('settled_by')->nullable();
            $table->timestamp('settlement_date')->nullable();
            $table->enum('payable_to', App\Enums::CLAIM_PAYABLE_TOS)->nullable();
            $table->string('claim_officer_remarks')->nullable();
            $table->boolean('doctor_approved')->default(false);
            $table->timestamp('doctor_approved_at')->nullable();
            $table->string('doctor_remarks')->nullable();
            $table->boolean('hod_approved')->default(false);
            $table->timestamp('hod_approved_at')->nullable();
            $table->string('hod_remarks')->nullable();
            $table->boolean('coo_approved')->default(false);
            $table->timestamp('coo_approved_at')->nullable();
            $table->string('coo_remarks')->nullable();
            $table->boolean('ceo_approved')->default(false);
            $table->timestamp('ceo_approved_at')->nullable();
            $table->string('ceo_remarks')->nullable();
            $table->string('claim_status')->default(1);
            $table->boolean('release_for_account')->default(false);
            $table->boolean('payment_done')->default(false);
            $table->boolean('eft_return_updated')->default(false);
            $table->string('eft_return_updated_by')->nullable();
            $table->timestamp('claim_status_updated_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('edited_by')->nullable();
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
        Schema::dropIfExists('claims');
    }
}
