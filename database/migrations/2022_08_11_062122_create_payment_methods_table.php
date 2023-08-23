<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(with(new PaymentMethod())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('method_name')->comment('Method Name');
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('branch');
            $table->string('branch_routing_no');
            $table->string('address');
            $table->boolean('transaction_id_required')->comment('false: not required, true: required')
                  ->default(false);
            $table->boolean('active_status')->comment('false: Inactive, true: Active')
                  ->default(true);
            $table->unsignedBigInteger('created_by')->comment('Who created this row');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Who lastly updated this row');
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
        Schema::dropIfExists(with(new PaymentMethod())->getTable());
    }
}
