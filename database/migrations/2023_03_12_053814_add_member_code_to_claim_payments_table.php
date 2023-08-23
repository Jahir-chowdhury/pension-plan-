<?php
use App\Models\ClaimPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberCodeToClaimPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(with(new ClaimPayment())->getTable(), function (Blueprint $table) {
            $table->string('member_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(with(new ClaimPayment())->getTable(), function (Blueprint $table) {
            // $table->string('member_code')->nullable();
        });
    }
}
