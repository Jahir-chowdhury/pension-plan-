<?php

use App\Models\Mortality;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((with(new Mortality())->getTable()), function (Blueprint $table) {
            $table->id();
            $table->integer('onboard_age');
            $table->double('qx',12);
            $table->double('tpx',12);
            $table->double('mortality_factor',12);
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
        Schema::dropIfExists('mortalities');
    }
}
