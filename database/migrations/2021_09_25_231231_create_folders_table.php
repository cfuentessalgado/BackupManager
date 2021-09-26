<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained();
            $table->string('path', 4096); // max linux path filename
            $table->string('ignore_patterns', 2000)->nullable();
            $table->string('backup_patterns', 2000)->nullable();
            $table->string('schedule_id')->nullable();
            $table->string('hour')->nullable()->default(null);
            $table->integer('max_backups')->default(1);
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
        Schema::dropIfExists('folders');
    }
}
