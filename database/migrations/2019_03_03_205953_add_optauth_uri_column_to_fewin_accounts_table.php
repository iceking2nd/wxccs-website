<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptauthUriColumnToFewinAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fewin_accounts', function (Blueprint $table) {
            $table->text("otpauth_uri")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fewin_accounts', function (Blueprint $table) {
            $table->dropColumn("otpauth_uri");
        });
    }
}
