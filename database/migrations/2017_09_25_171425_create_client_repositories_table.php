<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRepositoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_repositories', function (Blueprint $table) {
            $table->unsignedInteger('client_id');
            $table->string('name', 30);
            $table->foreign('client_id')->references('id')->on('clients');
            $table->primary(['client_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_repositories');
    }
}
