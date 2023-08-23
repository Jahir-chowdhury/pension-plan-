<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Contract;
class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new Contract())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->string('organization_id');
            $table->string('contract_tittle');
            $table->string('contract_version');
            $table->boolean('active_status')->comment('false: Inactive, true: Active')
                  ->default(true);
            $table->string('file_name');
            $table->string('path');
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
        Schema::dropIfExists('contracts');
    }
}
