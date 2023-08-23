<?php
use App\Models\ClaimPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidAmountToClaimPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(with(new ClaimPayment())->getTable(), function (Blueprint $table) {
            // $table->integer('paid_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claim_payments_table', function (Blueprint $table) {
            $table->integer('paid_amount')->nullable();
        });
    }
}
