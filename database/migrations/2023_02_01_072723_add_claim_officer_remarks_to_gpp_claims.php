<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Claim;
class AddClaimOfficerRemarksToGppClaims extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(with(new Claim())->getTable(), function (Blueprint $table) {
            // $table->string('claim_officer_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(with(new Claim())->getTable(), function (Blueprint $table) {
            // $table->dropColumn(['claim_officer_remarks']);
        });
    }
}
