<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->text("description")->nullable();
            $table->date("due_date")->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tasks_panel_id')->constrained('tasks_panels')->after('id')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('task_statuses','id');
            $table->softDeletes();
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
        Schema::dropIfExists('tasks');
    }
};
