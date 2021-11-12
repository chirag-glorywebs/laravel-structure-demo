<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorHandlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_handler', function (Blueprint $table) {
            $table->char('error_id', 36)->primary();
            $table->text('base_url');
            $table->string('remote_addr',50)->nullable();
            $table->text('error_msg');
            $table->string('error_type')->nullable();
            $table->char('created_by', 36)->nullable();
            // $table->tinyInteger('status')->default(1)->index()->comment = "0-InActive, 1-Active";                       
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
        Schema::dropIfExists('error_handler');
    }
}
