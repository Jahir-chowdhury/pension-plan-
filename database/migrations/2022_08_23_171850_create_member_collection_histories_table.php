<?php

use App\Models\MemberCollectionHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCollectionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new MemberCollectionHistory())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('org_collection_id');
            $table->string('installment_no');
            $table->string('member_id');
            $table->string('member_code');
            $table->unsignedInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedDouble('employeeContribution');
            $table->unsignedDouble('employerContribution');
            $table->unsignedDouble('amount');
            $table->unsignedDouble('accumulated_fund');
            $table->float('net_charge');
            $table->double('interest');
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
        Schema::dropIfExists('member_collection_histories');
    }
}
