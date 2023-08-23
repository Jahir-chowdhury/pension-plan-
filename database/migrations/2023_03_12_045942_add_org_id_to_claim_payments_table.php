<?php
use App\Models\ClaimPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrgIdToClaimPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(with(new ClaimPayment())->getTable(), function (Blueprint $table) {
            // $table->integer('org_id')->nullable();
            // $table->integer('member_id')->nullable();
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
            // $table->integer('org_id')->nullable();
            // $table->integer('member_id')->nullable();
        });
    }
}
