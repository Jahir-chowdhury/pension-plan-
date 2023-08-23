<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Collection;
class CreateOrganizationCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new Collection())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('org_id');
            $table->unsignedInteger('installment_no');
            $table->date('buisness_month')->comment('For which month of year');
            $table->date('due_date');
            $table->unsignedBigInteger('amount');
            $table->date('payment_recieved_date');
            $table->string('transaction_no')->nullable();
            $table->unsignedInteger('payment_method_id');
            $table->unsignedInteger('suspence_amount')->default(0);
            $table->unsignedInteger('members_count')->nullable();
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
        Schema::dropIfExists('org_collections');
    }
}
