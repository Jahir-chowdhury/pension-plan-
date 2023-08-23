<?php

use App\Models\ClaimPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new ClaimPayment())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->string('claim_id');
            $table->string('org_id');
            $table->string('member_id');
            $table->string('intimation_number');
            $table->string('advise_no');
            $table->string('old_advise_no')->nullable();
            $table->date('payment_date');
            $table->string('settled_amount');
            $table->double('paid_amount');
            $table->string('payment_chanel');
            $table->string('payment_method');
            $table->string('remarks')->nullable();
            $table->string('claim_type');
            $table->boolean('return_eft')->nullable();
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
        Schema::dropIfExists('claim_payments');
    }
};
