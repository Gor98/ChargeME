<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyParentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_company', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('parent_id')->unsigned()->nullable();
			$table->foreign('parent_id')->references('id')
					->on('companies')->onDelete('cascade');

			$table->bigInteger('child_id')->unsigned()->nullable();
			$table->foreign('child_id')->references('id')
					->on('companies')->onDelete('cascade');

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
        Schema::dropIfExists('company_company');
    }
}
