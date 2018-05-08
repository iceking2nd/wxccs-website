<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFewinAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fewin_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain_id')->unique();
            $table->string('steam_account')->unique();
            $table->string('fewin_account')->unique();
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
        Schema::dropIfExists('fewin_accounts');
    }
}
