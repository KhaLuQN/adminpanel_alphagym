<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToMembersubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::table('membersubscriptions', function (Blueprint $table) {
            $table->softDeletes(); // tạo cột deleted_at (nullable timestamp)
        });
    }

    public function down()
    {
        Schema::table('membersubscriptions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
